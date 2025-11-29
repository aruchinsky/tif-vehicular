<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonalControlController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\AcompanianteController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\ProductividadController;

//SIEMPRE QUE SE MODIFIQUEN ROLES, PERMISOS O SEEDERS, EJECUTAR:
// php artisan cache:clear
// php artisan permission:cache-reset
// php artisan route:clear
// php artisan optimize:clear


//
// -----------------------------------------------------------------------------
// 🔵 RUTA PÚBLICA (LANDING)
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

//
// -----------------------------------------------------------------------------
// 🟣 DASHBOARD – REDIRECCIÓN AUTOMÁTICA POR ROL
// -----------------------------------------------------------------------------
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

//
// -----------------------------------------------------------------------------
// 🔵 SECCIÓN PARA PERSONAL DE CONTROL (ROL: CONTROL)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:CONTROL'])->prefix('control')->name('control.')->group(function () {

    // Ruta asignada
    Route::get('/mi-ruta', [PersonalControlController::class, 'rutaAsignada'])
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


//
// -----------------------------------------------------------------------------
// 🔴 SECCIÓN PARA ADMINISTRADOR (ROL: ADMINISTRADOR)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:ADMINISTRADOR'])->group(function () {

    // ---------------------------------------------------------
    // 🟦 PERSONAL DE CONTROL (CRUD Completo)
    // ---------------------------------------------------------
    Route::prefix('personalcontrol')->name('personalcontrol.')->group(function () {
        Route::get('/', [PersonalControlController::class, 'index'])->name('index');
        Route::get('/create', [PersonalControlController::class, 'create'])->name('create');
        Route::post('/', [PersonalControlController::class, 'store'])->name('store');
        Route::get('/{personal_control}', [PersonalControlController::class, 'show'])->name('show');
        Route::get('/{personal_control}/edit', [PersonalControlController::class, 'edit'])->name('edit');
        Route::put('/{personal_control}', [PersonalControlController::class, 'update'])->name('update');
        Route::delete('/{personal_control}', [PersonalControlController::class, 'destroy'])->name('destroy');
    });

    // ---------------------------------------------------------
    // 🟧 CONDUCTORES (CRUD Completo)
    // ---------------------------------------------------------
    Route::prefix('conductores')->name('conductores.')->group(function () {
        Route::get('/', [ConductorController::class, 'index'])->name('index');
        Route::get('/create', [ConductorController::class, 'create'])->name('create');
        Route::post('/', [ConductorController::class, 'store'])->name('store');
        Route::get('/{conductor}', [ConductorController::class, 'show'])->name('show');
        Route::get('/{conductor}/edit', [ConductorController::class, 'edit'])->name('edit');
        Route::put('/{conductor}', [ConductorController::class, 'update'])->name('update');
        Route::delete('/{conductor}', [ConductorController::class, 'destroy'])->name('destroy');
    });

    // ---------------------------------------------------------
    // 🟩 ACOMPAÑANTES (CRUD Completo)
    // ---------------------------------------------------------
    Route::resource('acompaniante', AcompanianteController::class);

    // ---------------------------------------------------------
    // 🟨 VEHÍCULOS (CRUD Completo)
    // ---------------------------------------------------------
    Route::resource('vehiculo', VehiculoController::class);

    // ---------------------------------------------------------
    // 🟪 NOVEDADES (CRUD Completo)
    // ---------------------------------------------------------
    Route::prefix('novedades')->name('novedades.')->group(function () {
        Route::get('/', [NovedadController::class, 'index'])->name('index');
        Route::get('/create', [NovedadController::class, 'create'])->name('create');
        Route::post('/', [NovedadController::class, 'store'])->name('store');
        Route::get('/{novedad}', [NovedadController::class, 'show'])->name('show');
        Route::get('/{novedad}/edit', [NovedadController::class, 'edit'])->name('edit');
        Route::put('/{novedad}', [NovedadController::class, 'update'])->name('update');
        Route::delete('/{novedad}', [NovedadController::class, 'destroy'])->name('destroy');
    });

    // ---------------------------------------------------------
    // 🟫 PRODUCTIVIDAD
    // ---------------------------------------------------------

    // Panel general (gráfico + tabla)
    Route::get('/productividad', [ProductividadController::class, 'index'])
        ->name('productividad.index');

    // Ver registro individual
    Route::get('/productividad/{id}', [ProductividadController::class, 'show'])
        ->name('productividad.show');


});