<?php

use App\Http\Controllers\AcompanianteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\PersonalControlController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculoController;
use App\Models\Acompaniante;
use Illuminate\Support\Facades\Route;

// Define todas las rutas bajo el prefijo /api/v1
Route::prefix('v1')->group(function () {

    // --- RUTAS DE AUTENTICACIÓN ---
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        
        // Rutas que requieren autenticación
        Route::middleware('auth:api')->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });
    });


    //URL: /api/v1/personal-control
    Route::post('personal-control', [PersonalControlController::class, 'store']);
    Route::get('personal-control', [PersonalControlController::class, 'index']);
    Route::get('personal-control/{personal_control}', [PersonalControlController::class, 'show']);
    Route::put('personal-control/{personal_control}', [PersonalControlController::class, 'update']);
    Route::delete('personal-control/{personal_control}', [PersonalControlController::class, 'destroy']);





    // --- RUTAS DE RECURSOS (Movidas aquí) ---
    // Ahora la URL es: /api/v1/vehiculos
    Route::get('vehiculos', [VehiculoController::class, 'index']);
    Route::post('vehiculos', [VehiculoController::class, 'store']);
    Route::get('vehiculos/{vehiculo}', [VehiculoController::class, 'show']); // Mostrar un vehículo por ID
    Route::put('vehiculos/{vehiculo}', [VehiculoController::class, 'update']);
    Route::delete('vehiculos/{vehiculo}', [VehiculoController::class, 'destroy']);
    // Asumo que esta también debe ser una ruta de recurso de nivel superior
    
    // Ahora la URL es: /api/v1/conductores
    // Nota: Es común usar GET para listados, POST para crear (ej. index vs store).
    Route::get('conductores', [ConductorController::class, 'index']); 
    Route::post('crear-conductores', [ConductorController::class, 'store']);
    Route::get('conductores/{conductor}', [ConductorController::class, 'show']); // Ver 1
    Route::put('conductores/{conductor}', [ConductorController::class, 'update']); // Actualizar
    Route::delete('conductores/{conductor}', [ConductorController::class, 'destroy']); // Eliminar

    // --- RUTA de Acompañante ---
    
    Route::post('acompañante', [AcompanianteController::class, 'store']);
    Route::get('acompañante/{acompañante}', [AcompanianteController::class, 'show']);
    Route::put('acompañante/{acompañante}', [AcompanianteController::class, 'update']);
    Route::delete('acompañante/{acompañante}', [AcompanianteController::class, 'destroy']);

    // --- RUTAS DE NOVEDADES /api/v1/novedades---

    Route::get('novedades', [NovedadController::class, 'index']);
    Route::post('novedades', [NovedadController::class, 'store']);
    Route::get('novedades/{novedades}', [NovedadController::class, 'show']);
    Route::put('novedades/{novedades}', [NovedadController::class, 'update']);
    Route::put('novedades/{novedades}', [NovedadController::class, 'destroy']);

});