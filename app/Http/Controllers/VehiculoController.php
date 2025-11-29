<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\PersonalControl;
use App\Models\Conductor;
use App\Models\Productividad;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Mostrar listado de vehículos
     */
    public function index()
    {
        $vehiculos = Vehiculo::with(['conductor', 'personalControl'])
            ->orderBy('fecha_hora_control', 'desc')
            ->get();

        return view('modules.Vehiculo.index', compact('vehiculos'));
    }

    /**
     * Formulario para crear nuevo vehículo
     */
    public function create()
    {
        $personalControls = PersonalControl::all();
        $conductores = Conductor::all();

        return view('modules.Vehiculo.create', compact('personalControls', 'conductores'));
    }

    /**
     * Guardar vehículo nuevo
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'personal_control_id' => 'required|exists:personal_control,id',
            'conductor_id'        => 'required|exists:conductor,id',
            'fecha_hora_control'  => 'required|date_format:Y-m-d\TH:i',
            'marca_modelo'        => 'required|string|max:255',
            'dominio'             => 'required|string|max:20|unique:vehiculo,dominio',
            'color'               => 'nullable|string|max:50'
        ]);

        $vehiculo = Vehiculo::create($data);

        /**
         * PRODUCTIVIDAD AUTOMÁTICA
         * Si el usuario NO es administrador, se registra acción
         */
        $user = auth()->user();

        if ($user && !$user->hasRole('ADMINISTRADOR')) {

            $personalControlId = PersonalControl::where('user_id', $user->id)->value('id');

            if ($personalControlId) {

                // buscar o crear productividad de hoy
                $productividad = Productividad::firstOrCreate(
                    [
                        'personal_control_id' => $personalControlId,
                        'fecha' => now()->format('Y-m-d'),
                    ],
                    [
                        'total_conductor' => 0,
                        'total_vehiculos' => 0,
                        'total_acompanante' => 0
                    ]
                );

                // sumar vehículo
                $productividad->increment('total_vehiculos');
            }
        }

        return redirect()
            ->route('vehiculo.index')
            ->with('success', 'Vehículo registrado correctamente.');
    }

    /**
     * Mostrar detalle
     */
    public function show(Vehiculo $vehiculo)
    {
        return view('modules.Vehiculo.show', compact('vehiculo'));
    }

    /**
     * Formulario de edición
     */
    public function edit(Vehiculo $vehiculo)
    {
        $personalControls = PersonalControl::all();
        $conductores = Conductor::all();

        return view('modules.Vehiculo.edit', compact('vehiculo', 'personalControls', 'conductores'));
    }

    /**
     * Actualizar vehículo
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $data = $request->validate([
            'personal_control_id' => 'required|exists:personal_control,id',
            'conductor_id'        => 'required|exists:conductor,id',
            'fecha_hora_control'  => 'required|date_format:Y-m-d\TH:i',
            'marca_modelo'        => 'required|string|max:255',
            'dominio'             => 'required|string|max:20|unique:vehiculo,dominio,' . $vehiculo->id,
            'color'               => 'nullable|string|max:50'
        ]);

        $vehiculo->update($data);

        return redirect()
            ->route('vehiculo.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Eliminar vehículo
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return redirect()
            ->route('vehiculo.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }
}
