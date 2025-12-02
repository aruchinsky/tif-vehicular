<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\ControlPolicial;

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
}
