<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use App\Events\NovedadCreada;

class NovedadController extends Controller
{
    /**
     * Muestra todas las novedades en vista web.
     */
    public function index()
    {
        // Traer todas las novedades con su vehiculo
        $novedades = Novedad::with('vehiculo')->get();

        // Devolver vista con los datos
        return view('modules.Novedades.index', compact('novedades'));
    }

    /**
     * Muestra el formulario para crear nueva novedad
     */
    public function create()
    {
        // Obtener vehículos para el select
        $vehiculos = \App\Models\Vehiculo::all();

        return view('modules.Novedades.create', compact('vehiculos'));
    }

    /**
     * Almacena una nueva novedad
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehiculo_id' => 'required|integer|exists:vehiculo,id',
            'tipo_novedad' => 'required|string|max:100',
            'aplica' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:255'
        ]);

        // Crear la novedad y guardarla
        $novedad = Novedad::create($data);
        // Disparar el evento NovedadCreada
        event(new NovedadCreada($novedad));

        return redirect()->route('novedades.index')->with('success', 'Novedad creada correctamente.');
    }

    /**
     * Muestra la novedad específica
     */
    public function show(Novedad $novedad)
    {
        return view('modules.Novedades.show', compact('novedad'));
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit(Novedad $novedad)
    {
        $vehiculos = \App\Models\Vehiculo::all();
        return view('modules.Novedades.edit', compact('novedad', 'vehiculos'));
    }

    /**
     * Actualiza la novedad
     */
    public function update(Request $request, Novedad $novedad)
    {
        $data = $request->validate([
            'vehiculo_id' => 'required|integer|exists:vehiculo,id',
            'tipo_novedad' => 'required|string|max:100',
            'aplica' => 'required|string|max:50',
            'observaciones' => 'nullable|string|max:255'
        ]);

        $novedad->update($data);

        return redirect()->route('novedades.index')->with('success', 'Novedad actualizada correctamente.');
    }

    /**
     * Elimina una novedad
     */
    public function destroy(Novedad $novedad)
    {
        $novedad->delete();
        return redirect()->route('novedades.index')->with('success', 'Novedad eliminada correctamente.');
    }
}
