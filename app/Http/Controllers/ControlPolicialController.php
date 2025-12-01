<?php

namespace App\Http\Controllers;

use App\Models\ControlPolicial;
use App\Models\ControlPersonal;
use App\Models\Personal;
use Illuminate\Http\Request;

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

        // Cargos operativos (chofer, escopetero, operador, etc.)
        $cargos = \App\Models\CargoPolicial::orderBy('nombre')->get();

        return view('modules.ControlPolicial.create', compact('personal', 'cargos'));
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
        $control->load([
            'administrador',

            // Personal asignado
            'personalAsignado.personal',
            'personalAsignado.personal.cargo',
            'personalAsignado.rolOperativo',
            'personalAsignado.personal.usuario',

            // Vehículos requisados
            'vehiculosControlados.conductor',
            'vehiculosControlados.conductor.acompaniante',
            'vehiculosControlados.novedades',
        ]);

        return view('modules.ControlPolicial.show', compact('control'));
    }


    public function edit(ControlPolicial $control)
    {
        return view('modules.ControlPolicial.edit', compact('control'));
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
        ]);

        $control->update($data);

        return redirect()
            ->route('controles.show', $control)
            ->with('success', 'Control policial actualizado correctamente.');
    }

    public function destroy(ControlPolicial $control)
    {
        $control->delete();

        return redirect()
            ->route('controles.index')
            ->with('success', 'Control eliminado correctamente.');
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
