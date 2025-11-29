<?php

namespace App\Http\Controllers;

use App\Models\Productividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductividadController extends Controller
{
    /**
     * 📌 Panel general con gráfico + tabla paginada
     */
    public function index()
    {
        $productividades = Productividad::with('personalControl')
                                      ->orderBy('fecha', 'desc')
                                      ->paginate(10);

        // Datos agrupados para el gráfico
        $chartData = Productividad::select(
            'fecha',
            DB::raw('SUM(total_conductor) as total_conductores'),
            DB::raw('SUM(total_vehiculos) as total_vehiculos'),
            DB::raw('SUM(total_acompanante) as total_acompanantes')
        )
        ->groupBy('fecha')
        ->orderBy('fecha', 'asc')
        ->get();

        // Formatear fechas para el eje X
        $fechas = $chartData->pluck('fecha')->map(
            fn($date) => \Carbon\Carbon::parse($date)->format('d/m')
        );

        return view('modules.Productividad.index', [
            'productividades' => $productividades,
            'fechas'          => $fechas,
            'conductores'     => $chartData->pluck('total_conductores'),
            'vehiculos'       => $chartData->pluck('total_vehiculos'),
            'acompanantes'    => $chartData->pluck('total_acompanantes'),
        ]);
    }

    /**
     * 📌 Mostrar registro individual de productividad
     */
    public function show($id)
    {
        // Buscar el registro con su relación
        $productividad = Productividad::with('personalControl')->findOrFail($id);

        return view('modules.Productividad.show', compact('productividad'));
    }
}
