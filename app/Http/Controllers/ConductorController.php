<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\Acompaniante;
use App\Models\Productividad;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    // Mostrar todos los conductores
    public function index()
    {
        $conductores = Conductor::all();
        return view('modules.Conductor.index', compact('conductores'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        return view('modules.Conductor.create');
    }

    // Guardar un nuevo conductor
    public function store(Request $request)
    {
        $data = $request->validate([
            'dni_conductor' => 'required|string|max:20|unique:conductor,dni_conductor',
            'nombre_apellido' => 'required|string|max:255',
            'domicilio' => 'nullable|string|max:255',
            'categoria_carnet' => 'nullable|string|max:50',
            'tipo_conductor' => 'nullable|string|max:50',
            'destino' => 'nullable|string|max:255',
        ]);

        $conductor = Conductor::create($data);

        $user = auth()->user();
        if ($user && method_exists($user, 'isAdmin') && !$user->isAdmin()) {
            if (method_exists($user, 'getPersonalControlId')) {
                $idControl = $user->getPersonalControlId();
                if ($idControl) {
                    Productividad::logAction($idControl, 'total_conductor');
                }
            }
        }

        return redirect()
            ->route('conductores.index')
            ->with('success', 'Conductor registrado correctamente');
    }

    // Ver un conductor
    public function show(Conductor $conductor)
    {
        return view('modules.Conductor.show', compact('conductor'));
    }

    // Editar conductor
    public function edit(Conductor $conductor)
    {
        $acompañantes = Acompaniante::all();
        return view('modules.Conductor.edit', compact('conductor', 'acompañantes'));
    }

    // Actualizar conductor
    public function update(Request $request, Conductor $conductor)
{
    $validated = $request->validate([
        'dni_conductor'   => "required|string|max:20|unique:conductor,dni_conductor,{$conductor->id}",
        'nombre_apellido' => 'required|string|max:255',
        'domicilio'       => 'nullable|string|max:255',
        'categoria_carnet'=> 'nullable|string|max:255',
        'tipo_conductor'  => 'nullable|string|max:255',
        'destino'         => 'nullable|string|max:255',
        'acompaniante_id' => 'nullable|exists:acompaniante,id',
    ]);

    // No guardar porque no existe en la tabla
    unset($validated['acompaniante_id']);

    // Actualizar conductor
    $conductor->update($validated);

    return redirect()
        ->route('conductores.index')
        ->with('success', 'Conductor actualizado correctamente.');
}


    // Eliminar conductor
    public function destroy(Conductor $conductor)
{
    $conductor->delete();

    return redirect()
        ->route('conductores.index')
        ->with('success', 'Conductor eliminado correctamente');
}

}
