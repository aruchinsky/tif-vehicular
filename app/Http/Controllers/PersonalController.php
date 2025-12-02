<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\CargoPolicial;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Listado de policías (admin)
     */
    public function index()
    {
        $personal = Personal::with('cargo')
            ->orderBy('nombre_apellido')
            ->get();

        return view('modules.Personal.index', compact('personal'));
    }

    /**
     * Vista para crear un policía manualmente (no modal)
     */
    public function create()
    {
        $cargos = CargoPolicial::orderBy('nombre')->get();

        return view('modules.Personal.create', compact('cargos'));
    }

    /**
     * Store tradicional (formulario)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_apellido' => 'required|string|max:255',
            'legajo'          => 'nullable|string|max:20',
            'dni'             => 'required|string|max:20|unique:personal,dni',
            'jerarquia'       => 'nullable|string|max:50',
            'cargo_id'        => 'nullable|exists:cargos_policiales,id',
            'movil'           => 'nullable|string|max:255',
        ]);

        Personal::create($data);

        return redirect()
            ->route('personal.index')
            ->with('success', 'Policía registrado correctamente.');
    }

    /**
     * Store vía AJAX (modal dentro del Control Policial)
     */
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
            'status'   => 'ok',
            'personal' => $personal
        ]);
    }

    /**
     * Editar policía
     */
    public function edit(Personal $personal)
    {
        $cargos = CargoPolicial::orderBy('nombre')->get();

        return view('modules.Personal.edit', compact('personal', 'cargos'));
    }

    /**
     * Actualizar
     */
    public function update(Request $request, Personal $personal)
    {
        $data = $request->validate([
            'nombre_apellido' => 'required|string|max:255',
            'legajo'          => 'nullable|string|max:20',
            'dni'             => 'required|string|max:20|unique:personal,dni,' . $personal->id,
            'jerarquia'       => 'nullable|string|max:50',
            'cargo_id'        => 'nullable|exists:cargos_policiales,id',
            'movil'           => 'nullable|string|max:255',
        ]);

        $personal->update($data);

        return redirect()
            ->route('personal.index')
            ->with('success', 'Policía actualizado correctamente.');
    }

    /**
     * Eliminar
     */
    public function destroy(Personal $personal)
    {
        $personal->delete();

        return redirect()
            ->route('personal.index')
            ->with('success', 'Policía eliminado correctamente.');
    }
}
