<?php

namespace App\Http\Controllers;

use App\Models\ControlPolicial;
use App\Models\Novedad;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Acompaniante;
use App\Models\Conductor;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'controles_mes' => ControlPolicial::whereMonth('fecha', now()->month)->count(),
            'vehiculos_mes' => Vehiculo::whereMonth('fecha_hora_control', now()->month)->count(),
            'civiles_mes' => Acompaniante::whereMonth('created_at', now()->month)->count(),
            'alertas_48h' => Novedad::where('created_at', '>=', now()->subHours(48))->count(),
        ];

        // ========================================
        //   PRODUCTIVIDAD (últimos 30 días, por día)
        // ========================================
        $labels = [];
        $vehiculosData = [];
        $conductoresData = [];
        $acompanantesData = [];

        // desde hace 29 días hasta hoy (30 días en total)
        $inicio = Carbon::today()->subDays(29);
        $fin    = Carbon::today();

        for ($fecha = $inicio->copy(); $fecha->lte($fin); $fecha->addDay()) {

            // Etiqueta del eje X (ej: 05/12)
            $labels[] = $fecha->format('d/m');

            // Vehículos controlados ese día
            $vehiculosData[] = Vehiculo::whereDate('fecha_hora_control', $fecha)->count();

            // Conductores registrados ese día
            $conductoresData[] = Conductor::whereDate('created_at', $fecha)->count();

            // Acompañantes registrados ese día
            $acompanantesData[] = Acompaniante::whereDate('created_at', $fecha)->count();
        }

        $grafico = [
            'labels'        => $labels,
            'vehiculos'     => $vehiculosData,
            'conductores'   => $conductoresData,
            'acompanantes'  => $acompanantesData,
        ];

        // Últimos 10 controles creados por cualquier admin
        $controles = ControlPolicial::with('administrador')
            ->orderBy('fecha', 'desc')
            ->take(10)
            ->get();

        // Alertas urgentes
        $alertas = Novedad::whereIn('tipo_novedad', [
            'droga',
            'contrabando',
            'pedido de captura',
            'paradero',
        ])
        ->latest()
        ->take(10)
        ->get();

        return view('modules.Dashboard.admin-dashboard', 
                    compact('controles', 'alertas', 'stats', 'grafico'));
    }
}
