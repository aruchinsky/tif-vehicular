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

        // SUPERUSUARIO
        if ($user->hasRole('SUPERUSUARIO')) {
            return redirect()->route('dashboard.super');
        }

        // ADMINISTRADOR
        if ($user->hasRole('ADMINISTRADOR')) {
            return redirect()->route('dashboard.admin');
        }

        // OPERADOR
        if ($user->hasRole('OPERADOR')) {
            return redirect()->route('dashboard.operador');
        }

        // fallback
        return view('dashboard');
    }
}
