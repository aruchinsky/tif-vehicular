<?php

namespace App\Http\Controllers;

use App\Models\Productividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductividadController extends Controller
{
    /**
     * Muestra el panel de gráficos de productividad.
     */
    public function index()
    {
        // 1. Obtener los datos brutos de productividad (necesario para la tabla).
        // Ordenamos por fecha descendente para que los más recientes salgan primero.
        $productividades = Productividad::with('personalControl')
                                      ->orderBy('fecha', 'desc')
                                      ->paginate(10); // <-- Usar paginate()
        
        // 2. Consulta de datos AGRUPADOS para los gráficos:
        // Agrupa los datos por FECHA para obtener los totales diarios del sistema,
        // Y por PERSONAL DE CONTROL para ver la actividad individual.
        $chartData = Productividad::select(
            'fecha',
            DB::raw('SUM(total_conductor) as total_conductores'),
            DB::raw('SUM(total_vehiculos) as total_vehiculos'),
            DB::raw('SUM(total_acompanante) as total_acompanantes')
        )
        ->groupBy('fecha')
        ->orderBy('fecha', 'asc')
        ->get();

        // 3. Preparar los datos para Chart.js (o similar)
        $fechas = $chartData->pluck('fecha')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d/m'));
        $conductores = $chartData->pluck('total_conductores');
        $vehiculos = $chartData->pluck('total_vehiculos');
        $acompanantes = $chartData->pluck('total_acompanantes');


        return view('modules.Productividad.index', compact(
            'productividades', 
            'fechas', 
            'conductores', 
            'vehiculos', 
            'acompanantes'
        ));
    }
    
    // Eliminamos los métodos create, store, edit, update, show, destroy.
}