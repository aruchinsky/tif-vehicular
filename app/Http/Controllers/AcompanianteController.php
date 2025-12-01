<?php

namespace App\Http\Controllers;

use App\Models\Acompaniante;
use App\Models\Conductor;
use Illuminate\Http\Request;

class AcompanianteController extends Controller
{
    // 🔹 Listado
    public function index()
    {
        $acompañantes = Acompaniante::with('conductor')->get();

        return view('modules.Acompaniante.index', compact('acompañantes'));
    }

    // 🔹 Formulario crear
    public function create()
    {
        $conductores = Conductor::all();

        return view('modules.Acompaniante.create', compact('conductores'));
    }

    // 🔹 Guardar
    public function store(Request $request)
    {
        $data = $request->validate([
            'conductor_id'      => 'required|integer|exists:conductor,id',
            'dni_acompaniante'  => 'required|string|max:20|unique:acompaniante,dni_acompaniante',
            'nombre_apellido'   => 'required|string|max:255',
            'domicilio'         => 'nullable|string|max:255',
            'tipo_acompaniante' => 'nullable|string|max:100',
        ]);

        Acompaniante::create($data);

        return redirect()
            ->route('acompaniante.index')
            ->with('success', 'Acompañante registrado correctamente.');
    }

    // 🔹 Detalle
    public function show(Acompaniante $acompaniante)
    {
        return view('modules.Acompaniante.show', compact('acompaniante'));
    }

    // 🔹 Formulario edición
    public function edit(Acompaniante $acompaniante)
    {
        $conductores = Conductor::all();

        return view('modules.Acompaniante.edit', compact('acompaniante', 'conductores'));
    }

    // 🔹 Actualizar
    public function update(Request $request, Acompaniante $acompaniante)
    {
        $data = $request->validate([
            'conductor_id'      => 'required|integer|exists:conductor,id',
            'dni_acompaniante'  => "required|string|max:20|unique:acompaniante,dni_acompaniante,{$acompaniante->id}",
            'nombre_apellido'   => 'required|string|max:255',
            'domicilio'         => 'nullable|string|max:255',
            'tipo_acompaniante' => 'nullable|string|max:100',
        ]);

        $acompaniante->update($data);

        return redirect()
            ->route('acompaniante.index')
            ->with('success', 'Acompañante actualizado correctamente.');
    }

    // 🔹 Eliminar
    public function destroy(Acompaniante $acompaniante)
    {
        $acompaniante->delete();

        return redirect()
            ->route('acompaniante.index')
            ->with('success', 'Acompañante eliminado correctamente.');
    }
}
