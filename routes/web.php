<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ControlPolicialController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\AcompanianteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\ProductividadController;

// -----------------------------------------------------------------------------
// LANDING
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// -----------------------------------------------------------------------------
// DASHBOARD (redirige según rol)
// -----------------------------------------------------------------------------
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

// -----------------------------------------------------------------------------
// ZONA OPERADOR (OPERADOR + ADMIN + SUPERUSUARIO)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:OPERADOR|ADMINISTRADOR|SUPERUSUARIO'])
    ->prefix('control')
    ->name('control.')
    ->group(function () {

        // "Mi ruta": controles donde está asignado
        Route::get('/mi-ruta', [ControlPolicialController::class, 'rutaAsignada'])
            ->name('ruta');

        // Registrar Conductor
        Route::get('/conductores/create', [ConductorController::class, 'create'])
            ->name('conductores.create');
        Route::post('/conductores', [ConductorController::class, 'store'])
            ->name('conductores.store');

        // Registrar Acompañante
        Route::get('/acompaniante/create', [AcompanianteController::class, 'create'])
            ->name('acompaniante.create');
        Route::post('/acompaniante', [AcompanianteController::class, 'store'])
            ->name('acompaniante.store');

        // Registrar Vehículo
        Route::get('/vehiculo/create', [VehiculoController::class, 'create'])
            ->name('vehiculo.create');
        Route::post('/vehiculo', [VehiculoController::class, 'store'])
            ->name('vehiculo.store');
    });

// -----------------------------------------------------------------------------
// ZONA ADMIN / SUPERUSUARIO
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:ADMINISTRADOR|SUPERUSUARIO'])
    ->group(function () {

        // CONTROLES POLICIALES (panel integral)
        Route::resource('controles', ControlPolicialController::class)
            ->parameters([
                'controles' => 'control'
            ]);
            
        Route::post('/personal/store-ajax', [PersonalController::class, 'storeAjax'])
            ->name('personal.store-ajax');




        // Alias de compatibilidad para el menú antiguo "Personal Control"
        Route::get('/personalcontrol', fn () => redirect()->route('controles.index'))
            ->name('personalcontrol.index');

        // CONDUCTORES
        Route::prefix('conductores')->name('conductores.')->group(function () {
            Route::get('/', [ConductorController::class, 'index'])->name('index');
            Route::get('/create', [ConductorController::class, 'create'])->name('create');
            Route::post('/', [ConductorController::class, 'store'])->name('store');
            Route::get('/{conductor}', [ConductorController::class, 'show'])->name('show');
            Route::get('/{conductor}/edit', [ConductorController::class, 'edit'])->name('edit');
            Route::put('/{conductor}', [ConductorController::class, 'update'])->name('update');
            Route::delete('/{conductor}', [ConductorController::class, 'destroy'])->name('destroy');
        });

        // ACOMPAÑANTES
        Route::resource('acompaniante', AcompanianteController::class);

        // VEHÍCULOS
        Route::resource('vehiculo', VehiculoController::class);

        // NOVEDADES
        Route::prefix('novedades')->name('novedades.')->group(function () {
            Route::get('/', [NovedadController::class, 'index'])->name('index');
            Route::get('/create', [NovedadController::class, 'create'])->name('create');
            Route::post('/', [NovedadController::class, 'store'])->name('store');
            Route::get('/{novedad}', [NovedadController::class, 'show'])->name('show');
            Route::get('/{novedad}/edit', [NovedadController::class, 'edit'])->name('edit');
            Route::put('/{novedad}', [NovedadController::class, 'update'])->name('update');
            Route::delete('/{novedad}', [NovedadController::class, 'destroy'])->name('destroy');
        });

        // PRODUCTIVIDAD
        Route::get('/productividad', [ProductividadController::class, 'index'])
            ->name('productividad.index');
        Route::get('/productividad/{id}', [ProductividadController::class, 'show'])
            ->name('productividad.show');
    });
