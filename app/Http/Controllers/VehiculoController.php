<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\ControlPolicial;
use App\Models\ControlPersonal;
use App\Models\Conductor;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Listado general de vehículos civiles requisados
     */
    public function index()
    {
        $vehiculos = Vehiculo::with(['conductor', 'control', 'operador.personal'])
            ->orderBy('fecha_hora_control', 'desc')
            ->get();

        return view('modules.Vehiculo.index', compact('vehiculos'));
    }

    /**
     * Formulario crear (modo ADMIN)
     */
    public function create()
    {
        $controles  = ControlPolicial::orderBy('fecha', 'desc')->get();
        $operadores = ControlPersonal::with('personal', 'control')->get();
        $conductores = Conductor::all();

        return view('modules.Vehiculo.create', compact('controles', 'operadores', 'conductores'));
    }

    /**
     * Guardar vehículo nuevo
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'control_id'        => 'required|exists:controles_policiales,id',
            'operador_id'       => 'required|exists:control_personal,id',
            'conductor_id'      => 'required|exists:conductor,id',
            'fecha_hora_control'=> 'required|date_format:Y-m-d\TH:i',
            'marca_modelo'      => 'required|string|max:255',
            'dominio'           => 'required|string|max:20|unique:vehiculo,dominio',
            'color'             => 'nullable|string|max:50',
        ]);

        Vehiculo::create($data);

        // 👉 Si más adelante queremos ligar esto a productividad,
        // acá podemos enganchar lógica para sumar 1 al operador actual.

        return redirect()
            ->route('vehiculo.index')
            ->with('success', 'Vehículo registrado correctamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        $vehiculo->load(['conductor', 'control', 'operador.personal', 'novedades']);

        return view('modules.Vehiculo.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        $controles  = ControlPolicial::orderBy('fecha', 'desc')->get();
        $operadores = ControlPersonal::with('personal', 'control')->get();
        $conductores = Conductor::all();

        return view('modules.Vehiculo.edit', compact('vehiculo', 'controles', 'operadores', 'conductores'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $data = $request->validate([
            'control_id'        => 'required|exists:controles_policiales,id',
            'operador_id'       => 'required|exists:control_personal,id',
            'conductor_id'      => 'required|exists:conductor,id',
            'fecha_hora_control'=> 'required|date_format:Y-m-d\TH:i',
            'marca_modelo'      => 'required|string|max:255',
            'dominio'           => 'required|string|max:20|unique:vehiculo,dominio,' . $vehiculo->id,
            'color'             => 'nullable|string|max:50',
        ]);

        $vehiculo->update($data);

        return redirect()
            ->route('vehiculo.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return redirect()
            ->route('vehiculo.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }

    public function storeOperador(Request $request)
    {
        // VALIDACIÓN
        $data = $request->validate([
            // Vehículo
            'marca_modelo' => 'required|string|max:255',
            'dominio'      => 'required|string|max:20|unique:vehiculo,dominio',
            'color'        => 'nullable|string|max:100',

            // Conductor
            'dni_conductor'    => 'required|string|max:20',
            'nombre_apellido'  => 'required|string|max:255',
            'domicilio'        => 'nullable|string|max:255',
            'categoria_carnet' => 'nullable|string|max:50',
            'tipo_conductor'   => 'nullable|string|max:50',
            'destino'          => 'nullable|string|max:255',

            // Metadatos
            'control_id'  => 'required|integer|exists:controles_policiales,id',
            'operador_id' => 'required|integer|exists:personal,id',
        ]);

        // ============================================================
        // 1) CREAR O REUTILIZAR CONDUCTOR
        // ============================================================
        $conductor = Conductor::firstOrCreate(
            ['dni_conductor' => $data['dni_conductor']],
            [
                'nombre_apellido'  => $data['nombre_apellido'],
                'domicilio'        => $data['domicilio'],
                'categoria_carnet' => $data['categoria_carnet'],
                'tipo_conductor'   => $data['tipo_conductor'],
                'destino'          => $data['destino'],
            ]
        );

        // ============================================================
        // 2) CREAR VEHÍCULO VINCULADO A CONTROL + CONDUCTOR + OPERADOR
        // ============================================================
        Vehiculo::create([
            'fecha_hora_control' => now(),
            'marca_modelo'       => $data['marca_modelo'],
            'dominio'            => strtoupper($data['dominio']),
            'color'              => $data['color'],

            'conductor_id' => $conductor->id,
            'control_id'   => $data['control_id'],
            'operador_id'  => $data['operador_id'],
        ]);

        // ============================================================
        // 3) REDIRECCIÓN CON ÉXITO
        // ============================================================
        return redirect()
            ->route('control.operador.show', $data['control_id'])
            ->with('success', 'Vehículo y conductor registrados correctamente.');
    }

}
