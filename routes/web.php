<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SuperDashboardController;
use App\Http\Controllers\OperadorDashboardController;

use App\Http\Controllers\ControlPolicialController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\AcompanianteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\ProductividadController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CargoPolicialController;
use App\Http\Controllers\UserController; // módulo Usuarios

// -----------------------------------------------------------------------------
// LANDING
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// -----------------------------------------------------------------------------
// DASHBOARD PRINCIPAL (redirige según rol)
// -----------------------------------------------------------------------------
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

// -----------------------------------------------------------------------------
// DASHBOARDS POR ROL
// -----------------------------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // ADMINISTRADOR
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admin');

    // SUPERUSUARIO
    Route::get('/dashboard/super', [SuperDashboardController::class, 'index'])
        ->name('dashboard.super');

    // OPERADOR
    Route::get('/dashboard/operador', [OperadorDashboardController::class, 'index'])
        ->name('dashboard.operador');
});

// -----------------------------------------------------------------------------
// ZONA OPERADOR (OPERADOR + ADMIN + SUPERUSUARIO)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:OPERADOR|ADMINISTRADOR|SUPERUSUARIO'])
    ->prefix('control')
    ->name('control.')
    ->group(function () {

        // "Mi ruta": controles asignados al operador
        Route::get('/mi-ruta', [ControlPolicialController::class, 'rutaAsignada'])
            ->name('ruta');

        // Registrar Conductor (vista operador)
        Route::get('/conductores/create', [ConductorController::class, 'create'])
            ->name('conductores.create');

        // Registrar conductor desde el operador
        Route::post('/conductores/store-operador', [ConductorController::class, 'storeOperador'])
            ->name('conductores.store-operador');

        // Registrar vehículo desde operador (modal)
        Route::post('/vehiculo/store-operador', [VehiculoController::class, 'storeOperador'])
            ->name('vehiculo.store-operador');

        // Registrar Acompañante (operador)
        Route::get('/acompaniante/create', [AcompanianteController::class, 'create'])
            ->name('acompaniante.create');
        Route::post('/acompaniante', [AcompanianteController::class, 'store'])
            ->name('acompaniante.store');

        // Registrar Vehículo desde operador (form completo)
        Route::get('/vehiculo/create', [VehiculoController::class, 'create'])
            ->name('vehiculo.create');
        Route::post('/vehiculo', [VehiculoController::class, 'store'])
            ->name('vehiculo.store');

        // Detalle de control (vista Operador)
        Route::get('/operador/control/{control}', [OperadorDashboardController::class, 'show'])
            ->name('operador.show');

        // Exportar PDF de operativo
        Route::get('/exportar/pdf/{control}', [OperadorDashboardController::class, 'exportPdf'])
            ->name('export.pdf');

        // Registrar Novedad desde operador (modal)
        Route::post('/novedades/store-operador', [NovedadController::class, 'storeOperador'])
            ->name('novedades.store-operador');

        // Registrar Acompañante (OPERADOR, vía modal)
        Route::post('/acompaniante/store-operador', [AcompanianteController::class, 'storeOperador'])
            ->name('acompaniante.store-operador');

    });

// -----------------------------------------------------------------------------
// ZONA ADMIN / SUPERUSUARIO
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:ADMINISTRADOR|SUPERUSUARIO'])
    ->group(function () {

        // CONTROLES POLICIALES
        Route::resource('controles', ControlPolicialController::class)
            ->parameters(['controles' => 'control']);

        // ---------------------------------------------------------------------
        // PERSONAL POLICIAL
        // ---------------------------------------------------------------------

        // ABM completo de Personal (solo Admin + Super)
        Route::resource('personal', PersonalController::class)
            ->except(['show']); // por ahora sin vista de detalle

        // Registrar personal vía AJAX (modal dentro de Control)
        Route::post('/personal/store-ajax', [PersonalController::class, 'storeAjax'])
            ->name('personal.store-ajax');

        // Alias histórico: antes apuntaba a controles, ahora al módulo Personal
        Route::get('/personalcontrol', fn () => redirect()->route('personal.index'))
            ->name('personalcontrol.index');

        // ---------------------------------------------------------------------
        // CONDUCTORES
        // ---------------------------------------------------------------------
        Route::prefix('conductores')->name('conductores.')->group(function () {
            Route::get('/', [ConductorController::class, 'index'])->name('index');
            Route::get('/create', [ConductorController::class, 'create'])->name('create');
            Route::post('/', [ConductorController::class, 'store'])->name('store');
            Route::get('/{conductor}', [ConductorController::class, 'show'])->name('show');
            Route::get('/{conductor}/edit', [ConductorController::class, 'edit'])->name('edit');
            Route::put('/{conductor}', [ConductorController::class, 'update'])->name('update');
            Route::delete('/{conductor}', [ConductorController::class, 'destroy'])->name('destroy');
        });

        // ---------------------------------------------------------------------
        // ACOMPAÑANTES
        // ---------------------------------------------------------------------
        Route::resource('acompaniante', AcompanianteController::class);

        // ---------------------------------------------------------------------
        // VEHÍCULOS
        // ---------------------------------------------------------------------
        Route::resource('vehiculo', VehiculoController::class);

        // ---------------------------------------------------------------------
        // NOVEDADES
        // ---------------------------------------------------------------------
        Route::prefix('novedades')->name('novedades.')->group(function () {
            Route::get('/', [NovedadController::class, 'index'])->name('index');
            Route::get('/create', [NovedadController::class, 'create'])->name('create');
            Route::post('/', [NovedadController::class, 'store'])->name('store');
            Route::get('/{novedad}', [NovedadController::class, 'show'])->name('show');
            Route::get('/{novedad}/edit', [NovedadController::class, 'edit'])->name('edit');
            Route::put('/{novedad}', [NovedadController::class, 'update'])->name('update');
            Route::delete('/{novedad}', [NovedadController::class, 'destroy'])->name('destroy');
        });

        // ---------------------------------------------------------------------
        // PRODUCTIVIDAD
        // ---------------------------------------------------------------------
        Route::get('/productividad', [ProductividadController::class, 'index'])
            ->name('productividad.index');
        Route::get('/productividad/{id}', [ProductividadController::class, 'show'])
            ->name('productividad.show');

        // ---------------------------------------------------------------------
        // CARGOS POLICIALES
        // ---------------------------------------------------------------------
        Route::resource('cargos-policiales', CargoPolicialController::class)
            ->parameters(['cargos-policiales' => 'cargo']);


        // ---------------------------------------------------------------------
        // USUARIOS (solo SUPERUSUARIO)
// ---------------------------------------------------------------------
        Route::resource('usuarios', UserController::class)
            ->middleware('role:SUPERUSUARIO');
    });
