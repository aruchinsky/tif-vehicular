<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // SUPERUSUARIO → panel de controles
        if ($user->hasRole('SUPERUSUARIO')) {
            return redirect()->route('controles.index');
        }

        // ADMINISTRADOR → panel de controles
        if ($user->hasRole('ADMINISTRADOR')) {
            return redirect()->route('controles.index');
        }

        // OPERADOR → "Mi ruta" (controles donde está asignado)
        if ($user->hasRole('OPERADOR')) {
            return redirect()->route('control.ruta');
        }

        // fallback
        return view('dashboard');
    }
}
