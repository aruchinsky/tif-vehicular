<?php

namespace App\Http\Controllers;

use App\Models\Acompaniante;
use App\Models\Conductor;
use App\Models\Productividad;
use Illuminate\Http\Request;

class AcompanianteController extends Controller
{
    // 🔹 Mostrar todos los acompañantes
    public function index()
    {
        $acompañantes = Acompaniante::all();
        return view('modules.Acompaniante.index', compact('acompañantes'));
    }

    // 🔹 Mostrar formulario para crear
    public function create()
    {
        $conductores = Conductor::all(); // Obtener todos los conductores
        return view('modules.Acompaniante.create', compact('conductores')); // Pasar a la vista
    }
    // 🔹 Guardar nuevo acompañante
    public function store(Request $request)
    {
        $data = $request->validate([
            'conductor_id'      => 'required|integer|exists:conductor,id',
            'dni_acompaniante' => 'required|string|max:20|unique:acompaniante,dni_acompaniante',
            'nombre_apellido' => 'required|string|max:255',
            'domicilio' => 'nullable|string|max:255',
            'tipo_acompaniante' => 'nullable|string|max:100',
        ]);

        Acompaniante::create($data);
        $user = auth()->user();
        if ($user && !$user->isAdmin()) {
            $personalControlId = $user->getPersonalControlId();
            if ($personalControlId) {
                Productividad::logAction($personalControlId, 'total_acompanante');
            }
        }
        return redirect()->route('acompaniante.index')->with('success', 'Acompañante registrado correctamente.');
    }

    // 🔹 Mostrar detalle
    public function show(Acompaniante $acompaniante)
    {
        return view('modules.Acompaniante.show', compact('acompaniante'));
    }

    // 🔹 Mostrar formulario de edición
    public function edit(Acompaniante $acompaniante)
    {
        return view('modules.Acompaniante.edit', compact('acompaniante'));
    }

    // 🔹 Actualizar
    public function update(Request $request, Acompaniante $acompaniante)
    {
        $data = $request->validate([
            'dni_acompaniante' => "required|string|max:20|unique:acompaniante,dni_acompaniante,{$acompaniante->id}",
            'nombre_apellido' => 'required|string|max:255',
            'domicilio' => 'nullable|string|max:255',
            'tipo_acompaniante' => 'nullable|string|max:100',
        ]);

        $acompaniante->update($data);

        return redirect()->route('acompaniante.index')->with('success', 'Acompañante actualizado correctamente.');
    }

    // 🔹 Eliminar
    public function destroy(Acompaniante $acompaniante)
    {
        $acompaniante->delete();
        return redirect()->route('acompaniante.index')->with('success', 'Acompañante eliminado correctamente.');
    }
}
