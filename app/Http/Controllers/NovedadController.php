<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use App\Events\NovedadCreada;

class NovedadController extends Controller
{
    public function index()
    {
        $novedades = Novedad::with('vehiculo')->latest()->get();

        return view('modules.Novedades.index', compact('novedades'));
    }

    public function create()
    {
        $vehiculos = Vehiculo::with('conductor')->latest()->get();

        return view('modules.Novedades.create', compact('vehiculos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehiculo_id'   => 'required|integer|exists:vehiculo,id',
            'tipo_novedad'  => 'required|string|max:100',
            'aplica'        => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $novedad = Novedad::create($data);

        event(new NovedadCreada($novedad));

        return redirect()
            ->route('novedades.index')
            ->with('success', 'Novedad creada correctamente.');
    }

    public function show(Novedad $novedad)
    {
        return view('modules.Novedades.show', compact('novedad'));
    }

    public function edit(Novedad $novedad)
    {
        $vehiculos = Vehiculo::all();

        return view('modules.Novedades.edit', compact('novedad', 'vehiculos'));
    }

    public function update(Request $request, Novedad $novedad)
    {
        $data = $request->validate([
            'vehiculo_id'   => 'required|integer|exists:vehiculo,id',
            'tipo_novedad'  => 'required|string|max:100',
            'aplica'        => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $novedad->update($data);

        return redirect()
            ->route('novedades.index')
            ->with('success', 'Novedad actualizada correctamente.');
    }

    public function destroy(Novedad $novedad)
    {
        $novedad->delete();

        return redirect()
            ->route('novedades.index')
            ->with('success', 'Novedad eliminada correctamente.');
    }
}
