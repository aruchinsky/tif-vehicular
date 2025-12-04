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

        // Crear la novedad
        $novedad = Novedad::create($data);

        // Cargar relaciones necesarias para la alerta
        $novedad->load([
            'vehiculo',
            'vehiculo.conductor',
            'vehiculo.control',
        ]);

        // Emitir el evento INMEDIATAMENTE (sin colas)
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

    // ----------------------------------------------------------
    // REGISTRAR NOVEDAD DESDE OPERADOR
    // ----------------------------------------------------------
    public function storeOperador(Request $request)
    {
        $data = $request->validate([
            'vehiculo_id'   => 'required|exists:vehiculo,id',
            'tipo_novedad'  => 'required|string|max:255',
            'aplica'        => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'control_id'    => 'required|exists:controles_policiales,id',
        ]);

        // Crear novedad
        $novedad = Novedad::create([
            'vehiculo_id'   => $data['vehiculo_id'],
            'tipo_novedad'  => $data['tipo_novedad'],
            'aplica'        => $data['aplica'],
            'observaciones' => $data['observaciones'],
        ]);

        // Disparar evento en tiempo real
        broadcast(new NovedadCreada($novedad))->toOthers();

        return redirect()
            ->route('control.operador.show', $data['control_id'])
            ->with('success', 'Novedad registrada correctamente.');
    }

}
