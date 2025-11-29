<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        // ADMINISTRADOR → Panel completo
        if ($user->hasRole('ADMINISTRADOR')) {
            return redirect()->route('personalcontrol.index');
        }

        // PERSONAL DE CONTROL → Ruta asignada
        if ($user->hasRole('CONTROL')) {
            return redirect()->route('control.ruta');
        }

        // Fallback seguro
        return view('dashboard');
    }
}
