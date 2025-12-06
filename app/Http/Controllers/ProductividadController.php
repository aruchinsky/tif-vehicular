<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vehiculo;
use App\Models\Conductor;
use App\Models\Acompaniante;
use App\Models\Novedad;
use App\Models\ControlPersonal;
use App\Models\ControlPolicial;

class ProductividadController extends Controller
{
    /**
     * PANEL PRINCIPAL (SUPERUSUARIO)
     */
    public function index()
    {
        // ============================================================
        // 🔥 1) KPI GLOBAL DEL SISTEMA
        // ============================================================
        $kpi = [
            'vehiculos'    => Vehiculo::count(),
            'conductores'  => Conductor::count(),
            'acompanantes' => Acompaniante::count(),
            'novedades'    => Novedad::count(),
            'controles'    => ControlPolicial::count(),
        ];

        // ============================================================
        // 🔥 2) EVOLUCIÓN DIARIA (fecha → total registros)
        // ============================================================
        $dias = Vehiculo::select(
                    DB::raw("DATE(fecha_hora_control) as fecha"),
                    DB::raw("COUNT(*) as total")
                )
                ->groupBy("fecha")
                ->orderBy("fecha", "asc")
                ->get();

        $evolucion = [
            'fechas'  => $dias->pluck('fecha')->map(fn($f)=>\Carbon\Carbon::parse($f)->format("d/m")),
            'totales' => $dias->pluck('total'),
        ];

        // ============================================================
        // 🔥 3) RANKING DE OPERADORES (suma total por operador)
        // ============================================================
        $ranking = ControlPersonal::query()
            ->with('personal')
            ->get()
            ->map(function($cp) {

                $vehiculos   = Vehiculo::where('operador_id', $cp->personal_id)->count();
                $conductores = Vehiculo::where('operador_id', $cp->personal_id)->count(); // conductor x vehículo
                $acompanantes = Novedad::whereHas('vehiculo', function($q) use ($cp){
                    $q->where('operador_id', $cp->personal_id);
                })->count();

                $novedades = Novedad::whereHas('vehiculo', function($q) use ($cp){
                    $q->where('operador_id', $cp->personal_id);
                })->count();

                return (object)[
                    'nombre'       => $cp->personal->nombre_apellido ?? '—',
                    'vehiculos'    => $vehiculos,
                    'conductores'  => $conductores,
                    'acompanantes' => $acompanantes,
                    'novedades'    => $novedades,
                    'total'        => $vehiculos + $conductores + $acompanantes + $novedades,
                ];
            })
            ->sortByDesc('total')
            ->values();

        // ============================================================
        // 🔥 4) DISTRIBUCIÓN GLOBAL TIPO DE REGISTRO (Pie chart)
        // ============================================================
        $torta = [
            'conductores'  => Vehiculo::count(),
            'vehiculos'    => Vehiculo::count(),
            'acompanantes' => Acompaniante::count(),
            'novedades'    => Novedad::count(),
        ];

        // ============================================================
        // 🔥 5) DETECCIÓN DE ANOMALÍAS
        // ============================================================
        $anomalias = [];

        // 5.1 Vehículos duplicados el mismo día
        $duplicados = Vehiculo::select('dominio', DB::raw("DATE(fecha_hora_control) as fecha"), DB::raw("COUNT(*) as cant"))
            ->groupBy('dominio','fecha')
            ->having('cant','>',1)
            ->get();

        foreach($duplicados as $d) {
            $anomalias[] = "Vehículo {$d->dominio} registrado {$d->cant} veces el día {$d->fecha}.";
        }

        // 5.2 Operadores sin actividad en días con controles
        $dias_controles = ControlPolicial::select(DB::raw("DATE(fecha) as fecha"))->distinct()->get();

        $operadores = ControlPersonal::with('personal')->get();

        foreach($operadores as $op) {
            foreach($dias_controles as $d) {

                $reg = Vehiculo::where('operador_id', $op->personal_id)
                        ->whereDate('fecha_hora_control', $d->fecha)
                        ->count();

                if($reg == 0) {
                    $anomalias[] =
                        "El operador {$op->personal->nombre_apellido} no registró actividad el día {$d->fecha}.";
                }
            }
        }

        // ============================================================
        // 🔥 6) ENVÍO A LA VISTA
        // ============================================================
        return view('modules.Productividad.index', [
            'kpi'        => $kpi,
            'evolucion'  => $evolucion,
            'ranking'    => $ranking,
            'torta'      => array_values($torta),
            'anomalias'  => $anomalias,
        ]);
    }
}
