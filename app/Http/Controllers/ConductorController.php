<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\Acompaniante;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    // ----------------------------------------------------------
    // LISTADO GENERAL (ADMIN)
    // ----------------------------------------------------------
    public function index()
    {
        $conductores = Conductor::with('acompaniante')->get();

        return view('modules.Conductor.index', compact('conductores'));
    }

    // ----------------------------------------------------------
    // FORM CREAR (ADMIN)
    // ----------------------------------------------------------
    public function create()
    {
        return view('modules.Conductor.create');
    }

    // ----------------------------------------------------------
    // GUARDAR (ADMIN)
    // ----------------------------------------------------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'dni_conductor'    => 'required|string|max:20|unique:conductor,dni_conductor',
            'nombre_apellido'  => 'required|string|max:255',
            'domicilio'        => 'nullable|string|max:255',
            'categoria_carnet' => 'nullable|string|max:50',
            'tipo_conductor'   => 'nullable|string|max:50',
            'destino'          => 'nullable|string|max:255',
        ]);

        Conductor::create($data);

        return redirect()
            ->route('conductores.index')
            ->with('success', 'Conductor registrado correctamente.');
    }

    // ----------------------------------------------------------
    // VER UNO (ADMIN)
    // ----------------------------------------------------------
    public function show(Conductor $conductor)
    {
        return view('modules.Conductor.show', compact('conductor'));
    }

    // ----------------------------------------------------------
    // FORM EDITAR (ADMIN)
    // ----------------------------------------------------------
    public function edit(Conductor $conductor)
    {
        $acompañantes = Acompaniante::where('conductor_id', $conductor->id)->get();

        return view('modules.Conductor.edit', compact('conductor', 'acompañantes'));
    }

    // ----------------------------------------------------------
    // ACTUALIZAR (ADMIN)
    // ----------------------------------------------------------
    public function update(Request $request, Conductor $conductor)
    {
        $validated = $request->validate([
            'dni_conductor'    => "required|string|max:20|unique:conductor,dni_conductor,{$conductor->id}",
            'nombre_apellido'  => 'required|string|max:255',
            'domicilio'        => 'nullable|string|max:255',
            'categoria_carnet' => 'nullable|string|max:50',
            'tipo_conductor'   => 'nullable|string|max:50',
            'destino'          => 'nullable|string|max:255',
        ]);

        $conductor->update($validated);

        return redirect()
            ->route('conductores.index')
            ->with('success', 'Conductor actualizado correctamente.');
    }

    // ----------------------------------------------------------
    // ELIMINAR (ADMIN)
    // ----------------------------------------------------------
    public function destroy(Conductor $conductor)
    {
        $conductor->delete();

        return redirect()
            ->route('conductores.index')
            ->with('success', 'Conductor eliminado correctamente.');
    }

}
