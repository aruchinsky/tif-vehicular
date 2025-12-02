<?php

namespace App\Http\Controllers;

use App\Models\CargoPolicial;
use Illuminate\Http\Request;

class CargoPolicialController extends Controller
{
    public function index()
    {
        $cargos = CargoPolicial::orderBy('nombre')->get();

        return view('modules.CargosPoliciales.index', compact('cargos'));
    }

    public function create()
    {
        return view('modules.CargosPoliciales.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:cargos_policiales,nombre',
        ]);

        CargoPolicial::create($data);

        return redirect()
            ->route('cargos-policiales.index')
            ->with('success', 'Cargo policial creado correctamente.');
    }

    public function edit(CargoPolicial $cargo)
    {
        return view('modules.CargosPoliciales.edit', compact('cargo'));
    }

    public function update(Request $request, CargoPolicial $cargo)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:cargos_policiales,nombre,' . $cargo->id,
        ]);

        $cargo->update($data);

        return redirect()
            ->route('cargos-policiales.index')
            ->with('success', 'Cargo policial actualizado correctamente.');
    }

    public function destroy(CargoPolicial $cargo)
    {
        $cargo->delete();

        return redirect()
            ->route('cargos-policiales.index')
            ->with('success', 'Cargo policial eliminado correctamente.');
    }
}
