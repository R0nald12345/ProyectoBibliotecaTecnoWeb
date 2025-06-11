<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas para la gestión de usuarios
    Route::apiResource('usuarios', UsuarioController::class);
    
    // Rutas para la gestión de roles
    Route::apiResource('roles', RolController::class);
    
    // Rutas para la gestión de permisos
    Route::apiResource('permisos', PermisoController::class);

    
    // Ruta para verificar QR
    Route::post('/verificar-qr', [AsistenciaController::class, 'verificarQR']);
});