<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehiculo;
use App\Models\Conductor;
use App\Models\Acompaniante;
use App\Models\Novedad;
use App\Models\ControlPolicial;
use App\Models\Productividad;

class SuperDashboardController extends Controller
{
    public function index()
    {
        $hoy       = Carbon::today();
        $hace48h   = Carbon::now()->subHours(48);
        $inicioMes = Carbon::now()->startOfMonth();

        // ============================================================
        // 1) KPIs PRINCIPALES DEL MES
        // ============================================================
        $stats = [
            'controles_mes'   => ControlPolicial::where('fecha', '>=', $inicioMes)->count(),
            'vehiculos_mes'   => Vehiculo::where('fecha_hora_control', '>=', $inicioMes)->count(),
            'civiles_mes'     => Conductor::where('created_at', '>=', $inicioMes)->count()
                                 + Acompaniante::where('created_at', '>=', $inicioMes)->count(),
            'alertas_48h'     => Novedad::where('created_at', '>=', $hace48h)->count(),
        ];

        // ============================================================
        // 2) ALERTAS URGENTES (Para fallback en la vista)
        // ============================================================
        $alertas = Novedad::with(['vehiculo'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // ============================================================
        // 3) CONTROLES ACTIVOS HOY
        // ============================================================
        $controlesHoy = ControlPolicial::whereDate('fecha', $hoy)
            ->with(['vehiculosControlados'])
            ->orderBy('hora_inicio')
            ->get();

        // ============================================================
        // 4) ÚLTIMOS CONTROLES (Sección informativa)
        // ============================================================
        $controles = ControlPolicial::orderBy('fecha', 'desc')
            ->take(10)
            ->get();

        // ============================================================
        // 5) PRODUCTIVIDAD PARA GRÁFICO (Últimos 30 días)
        // ============================================================
        $inicio30 = Carbon::now()->subDays(30);

        $productividad = Productividad::where('fecha', '>=', $inicio30)
            ->orderBy('fecha')
            ->get();

        // Preparamos datasets para ChartJS
        $labels         = [];
        $vehiculos      = [];
        $conductores    = [];
        $acompanantes   = [];

        foreach ($productividad as $p) {
            $labels[]       = Carbon::parse($p->fecha)->format('d/m');
            $vehiculos[]    = $p->total_vehiculos;
            $conductores[]  = $p->total_conductor;
            $acompanantes[] = $p->total_acompanante;
        }

        $grafico = [
            'labels'        => $labels,
            'vehiculos'     => $vehiculos,
            'conductores'   => $conductores,
            'acompanantes'  => $acompanantes,
        ];

        // ============================================================
        // RENDERIZAMOS LA VISTA DEL SUPERUSUARIO
        // ============================================================
        return view('modules.Dashboard.super-dashboard', compact(
            'stats',
            'alertas',
            'controlesHoy',
            'controles',
            'grafico'
        ));
    }
}
