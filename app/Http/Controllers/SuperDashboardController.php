<?php

namespace App\Http\Controllers;

use App\Models\ControlPolicial;
use Illuminate\Http\Request;

class SuperDashboardController extends Controller
{
    public function index()
    {
        // El superusuario ve absolutamente todo
        $controles = ControlPolicial::orderBy('fecha', 'desc')->take(10)->get();

        return view('modules.Dashboard.super-dashboard', compact('controles'));
    }
}
