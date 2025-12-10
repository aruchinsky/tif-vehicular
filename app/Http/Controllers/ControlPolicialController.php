<?php

namespace App\Http\Controllers;

use App\Models\ControlPolicial;
use App\Models\ControlPersonal;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Conductor;
use App\Models\Acompaniante;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\CargoPolicial;


class ControlPolicialController extends Controller
{
    /**
     * Listado de controles (ADMIN / SUPERUSUARIO)
     */
    public function index()
    {
        $controles = ControlPolicial::with(['administrador', 'personalAsignado.personal'])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('modules.ControlPolicial.index', compact('controles'));
    }

    public function create()
    {
        // Policías existentes
        $personal = Personal::with('cargo')
            ->orderBy('nombre_apellido')
            ->get();

        // Cargos operativos
        $cargos = CargoPolicial::orderBy('nombre')->get();

        // ID del cargo OPERADOR
        $cargoOperadorId = CargoPolicial::where('nombre', 'OPERADOR')->value('id');

        return view('modules.ControlPolicial.create', compact('personal', 'cargos', 'cargoOperadorId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha'        => 'required|date',
            'hora_inicio'  => 'required|date_format:H:i',
            'hora_fin'     => 'required|date_format:H:i',
            'lugar'        => 'required|string|max:255',
            'ruta'         => 'nullable|string|max:255',
            'movil_asignado' => 'nullable|string|max:255',

            // Nuevo
            'personal'     => 'required|array',        // IDs de policías asignados
            'roles'        => 'required|array',        // ID rol operativo por policía
        ]);

        // Guardamos el control
        $data['administrador_id'] = auth()->id();

        $control = ControlPolicial::create($data);

        // Guardamos asignaciones
        foreach ($data['personal'] as $personalId) {

            ControlPersonal::create([
                'control_id'       => $control->id,
                'personal_id'      => $personalId,
                'rol_operativo_id' => $data['roles'][$personalId],
            ]);
        }

        return redirect()
            ->route('controles.show', $control)
            ->with('success', 'Control policial creado correctamente.');
    }

    public function storeAjax(Request $request)
    {
        $data = $request->validate([
            'nombre_apellido' => 'required|string|max:255',
            'legajo'          => 'nullable|string|max:20',
            'dni'             => 'required|string|max:20|unique:personal,dni',
            'jerarquia'       => 'nullable|string|max:50',
            'cargo_id'        => 'nullable|exists:cargos_policiales,id',
            'movil'           => 'nullable|string|max:255',
        ]);

        $personal = Personal::create($data);

        return response()->json([
            'status' => 'ok',
            'personal' => $personal
        ]);
    }



    /**
     * PANEL INTEGRAL DEL CONTROL (Tabs pills modernos)
     */
    public function show(ControlPolicial $control)
    {
        // Cargar relaciones necesarias
        $control->load([
            'administrador',
            'personalAsignado.personal',
            'personalAsignado.personal.cargo',
            'personalAsignado.rolOperativo',
            'personalAsignado.personal.usuario',
            'vehiculosControlados.conductor',
            'vehiculosControlados.conductor.acompaniante',
            'vehiculosControlados.novedades',
            'vehiculosControlados.operador',
        ]);

        // ============================
        // 1) TOTALES GENERALES
        // ============================
        $totalVehiculos = $control->vehiculosControlados->count();
        $totalConductores = $totalVehiculos;
        $totalAcompanantes = $control->vehiculosControlados->sum(
            fn($v) => $v->conductor?->acompaniante?->count() ?? 0
        );
        $totalNovedades = $control->vehiculosControlados->sum(
            fn($v) => $v->novedades?->count() ?? 0
        );

        // ============================
        // 2) PRODUCTIVIDAD POR OPERADOR
        // ============================
        $operadoresAsignados = $control->personalAsignado->filter(
            fn($p) => strtoupper($p->rolOperativo?->nombre) === 'OPERADOR'
        );

        $labels = [];
        $vehiculosData = [];
        $acompanantesData = [];
        $novedadesData = [];

        foreach ($operadoresAsignados as $asig) {

            $persona = $asig->personal;
            $vehiculos = $persona->vehiculosCargados ?? collect();

            $labels[] = $persona->nombre_apellido;
            $vehiculosData[] = $vehiculos->count();
            $acompanantesData[] = $vehiculos->sum(fn($v) => $v->conductor?->acompaniante?->count() ?? 0);
            $novedadesData[] = $vehiculos->sum(fn($v) => $v->novedades?->count() ?? 0);
        }

        $graficoOperadores = [
            'labels'        => $labels,
            'vehiculos'     => $vehiculosData,
            'acompanantes'  => $acompanantesData,
            'novedades'     => $novedadesData,
        ];

        return view('modules.ControlPolicial.show', compact(
            'control',
            'totalVehiculos',
            'totalConductores',
            'totalAcompanantes',
            'totalNovedades',
            'graficoOperadores'
        ));
    }


    public function edit(ControlPolicial $control)
    {
        $control->load([
            'personalAsignado.personal',
            'personalAsignado.rolOperativo',
        ]);

        $personal = Personal::orderBy('nombre_apellido')->get();
        $cargos = CargoPolicial::orderBy('nombre')->get();

        // ID del cargo OPERADOR (necesario para validación en Alpine)
        $cargoOperadorId = CargoPolicial::where('nombre', 'OPERADOR')->value('id');

        // Preparamos datos para Alpine
        $asignados = $control->personalAsignado->map(function ($cp) {
            return [
                'id'     => $cp->personal_id,
                'nombre' => $cp->personal->nombre_apellido,
                'rol_id' => $cp->rol_operativo_id,
            ];
        });

        $listaPersonal = $personal->map(function ($p) {
            return [
                'id'     => $p->id,
                'nombre' => $p->nombre_apellido,
                'tiene_usuario' => $p->user_id !== null, // necesario también aquí
            ];
        });

        return view('modules.ControlPolicial.edit', compact(
            'control',
            'cargos',
            'asignados',
            'listaPersonal',
            'cargoOperadorId' // ← YA ESTÁ
        ));
    }



    public function update(Request $request, ControlPolicial $control)
    {
        $data = $request->validate([
            'fecha'        => 'required|date',
            'hora_inicio'  => 'required|date_format:H:i',
            'hora_fin'     => 'required|date_format:H:i',
            'lugar'        => 'required|string|max:255',
            'ruta'         => 'nullable|string|max:255',
            'movil_asignado' => 'nullable|string|max:255',

            'personal'     => 'required|array',
            'roles'        => 'required|array',
        ]);

        // Actualizamos datos del operativo
        $control->update($data);

        // Sincronizar personal asignado:
        // Borramos asignaciones actuales y las volvemos a crear según el formulario
        \App\Models\ControlPersonal::where('control_id', $control->id)->delete();

        foreach ($data['personal'] as $personalId) {
            \App\Models\ControlPersonal::create([
                'control_id'       => $control->id,
                'personal_id'      => $personalId,
                'rol_operativo_id' => $data['roles'][$personalId] ?? null,
            ]);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Control policial actualizado correctamente.');

    }


    public function destroy(ControlPolicial $control)
    {
        // Chequear si el control tiene novedades en cualquiera de sus vehículos
        $tieneNovedades = $control->vehiculosControlados()
            ->whereHas('novedades')
            ->exists();

        if ($tieneNovedades) {
            return redirect()
                ->route('controles.show', $control)
                ->with('error', 'No se puede eliminar este control porque ya tiene novedades registradas.');
        }

        // Si NO tiene novedades → eliminar normalmente
        $control->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Control policial eliminado correctamente.');
    }


    /**
     * "Mi ruta" para OPERADOR: controles donde el usuario está asignado
     */
    public function rutaAsignada()
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        // Personal asociado a este usuario
        $personal = Personal::where('user_id', $user->id)->first();

        if (!$personal) {
            // Sin personal asociado → pantalla vacía amable
            return view('modules.ControlPolicial.ruta-asignada-vacia');
        }

        $controles = ControlPolicial::whereHas('personalAsignado', function ($q) use ($personal) {
                $q->where('personal_id', $personal->id);
            })
            ->with('personalAsignado.personal')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('modules.ControlPolicial.ruta-asignada', compact('controles', 'personal'));
    }
}
