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
        $vehiculos = Vehiculo::with(['conductor', 'personalControl'])->get();

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
            'conductor_id' => 'required|exists:conductor,id',
            'fecha_hora_control' => 'required|date_format:Y-m-d\TH:i',
            'marca_modelo' => 'required|string|max:255',
            'dominio' => 'required|string|max:20|unique:vehiculo,dominio',
            'color' => 'nullable|string|max:50'
        ]);

        $vehiculo = Vehiculo::create($data);
        $user = auth()->user();
        if ($user && !$user->isAdmin()) {
            $personalControlId = $user->getPersonalControlId();
            if ($personalControlId) {
                Productividad::logAction($personalControlId, 'total_vehiculos');
            }
        }
        return redirect()->route('vehiculo.index')->with('success', 'Vehículo registrado correctamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        // Si estás usando vistas con Jetstream:
        return view('modules.Vehiculo.show', compact('vehiculo'));

        // O si estás usando API:
        // return response()->json($vehiculo);
    }


    /**
     * Formulario para editar vehículo existente
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
            'conductor_id' => 'required|exists:conductor,id',
            'fecha_hora_control' => 'required|date_format:Y-m-d\TH:i',
            'marca_modelo' => 'required|string|max:255',
            'dominio' => 'required|string|max:20|unique:vehiculo,dominio,' . $vehiculo->id,
            'color' => 'nullable|string|max:50'
        ]);

        $vehiculo->update($data);

        return redirect()->route('vehiculo.index')->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Eliminar vehículo
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return redirect()->route('vehiculo.index')->with('success', 'Vehículo eliminado correctamente.');
    }
}
