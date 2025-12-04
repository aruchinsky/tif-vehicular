<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\ControlPolicial;
use App\Models\CargoPolicial;
use Barryvdh\DomPDF\Facade\Pdf; // asegurate de tener este use arriba

class OperadorDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Traemos el personal asociado al usuario operador
        $personal = Personal::where('user_id', $user->id)->first();

        if (!$personal) {
            return view('modules.Dashboard.operador-dashboard', [
                'controles' => [],
                'personal' => null,
            ]);
        }

        // Controles donde está asignado el operador
        $controles = ControlPolicial::whereHas('personalAsignado', function ($q) use ($personal) {
                $q->where('personal_id', $personal->id);
            })
            ->orderBy('fecha', 'desc')
            ->get();

        return view('modules.Dashboard.operador-dashboard', compact('controles', 'personal'));
    }

    /**
     * Vista principal del operador dentro de un control.
     */
    public function show($controlId)
    {
        $user = auth()->user();

        // Relación personal <-> usuario
        $personal = $user->personal;

        if (!$personal) {
            abort(403, 'No estás autorizado para acceder a esta sección.');
        }


        // ================================
        // VALIDAR QUE EL OPERADOR ESTÉ ASIGNADO A ESTE CONTROL
        // ================================
        $control = ControlPolicial::with([
            'vehiculosControlados',
            'vehiculosControlados.conductor',
            'vehiculosControlados.conductor.acompaniante',
            'vehiculosControlados.novedades',
        ])->findOrFail($controlId);


        // Obtener el ID del cargo "Operador"
        $operadorCargoId = CargoPolicial::where('nombre', 'Operador')->value('id');

        // Validar asignación del operador
        $estaAsignado = $control->personalAsignado()
            ->where('personal_id', $personal->id)
            ->where('rol_operativo_id', $operadorCargoId)
            ->exists();

        if (!$estaAsignado) {
            return redirect()
                ->route('dashboard.operador')
                ->with('error', 'No estás asignado a este control policial.');
        }



        // ================================
        // PREPARAR DATOS PARA LA VISTA OPERADOR
        // ================================
        $vehiculos   = $control->vehiculosControlados;
        $conductores = $vehiculos->pluck('conductor')->filter();
        $novedades   = $vehiculos->flatMap->novedades;



        // ================================
        // RETORNAR VISTA PRINCIPAL
        // ================================
        return view('modules.Operador.show-operador', [
            'control'     => $control,
            'conductores' => $conductores,
            'vehiculos'   => $vehiculos,
            'novedades'   => $novedades,
            'personal'    => $personal,
        ]);
    }

    public function exportPdf($controlId)
    {
        $user = auth()->user();
        $personal = $user->personal;

        if (!$personal) {
            abort(403, 'No estás autorizado para acceder a esta sección.');
        }

        // MISMA VALIDACIÓN QUE EN EL SHOW
        $operadorCargoId = CargoPolicial::where('nombre', 'Operador')->value('id');

        $control = ControlPolicial::with([
            'vehiculosControlados',
            'vehiculosControlados.conductor',
            'vehiculosControlados.conductor.acompaniante',
            'vehiculosControlados.novedades',
        ])->findOrFail($controlId);

        $estaAsignado = $control->personalAsignado()
            ->where('personal_id', $personal->id)
            ->where('rol_operativo_id', $operadorCargoId)
            ->exists();

        if (!$estaAsignado) {
            abort(403, 'No estás asignado a este control policial.');
        }

        // DATOS PARA EL PDF
        $vehiculos = $control->vehiculosControlados;
        $conductores = $vehiculos->pluck('conductor')->filter();
        $novedades = $vehiculos->flatMap->novedades;

        // GENERAR PDF
        $pdf = Pdf::loadView('modules.Operador.pdf-operativo', [
            'control'     => $control,
            'conductores' => $conductores,
            'vehiculos'   => $vehiculos,
            'novedades'   => $novedades,
            'personal'    => $personal,
        ]);

        //
        // Nombre del archivo
        //
        $filename = 'Operativo_' . $control->id . '_' . date('Y-m-d_H-i') . '.pdf';

        return $pdf->download($filename);
    }
}
