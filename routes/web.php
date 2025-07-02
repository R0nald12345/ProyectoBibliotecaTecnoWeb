<?php

use App\Http\Controllers\AsistenciaController;


use App\Http\Controllers\GestionController;

use App\Http\Controllers\HolaMundoController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\VerificacionController;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('gestion', GestionController::class);
Route::resource('roles', RoleController::class);



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/hola', [HolaMundoController::class, 'index'])->name('hola');

    Route::get('/asistencia', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::post('/asistencia', [AsistenciaController::class, 'registrar'])->name('asistencia.registrar');
    Route::get('/scrap-estudiante', [ScraperController::class, 'scrape'])->name('scraper.scrape');


    // Rutas para la gestión de usuarios
    Route::get('/usuarios', function () {
        return Inertia::render('Usuario/Index');
    })->name('usuarios.index');

    // Rutas para la gestión de roles
    Route::get('/roles', function () {
        return Inertia::render('Rol/Index');
    })->name('roles.index');

    // Rutas para la gestión de permisos
    Route::get('/permisos', function () {
        return Inertia::render('Permiso/Index');
    })->name('permisos.index');

    // Ruta para el dashboard de asistencias
    Route::get('/asistencias', function () {
        return Inertia::render('Asistencia/Index');
    })->name('asistencias.dashboard');

    Route::get('/roles', function () {
        return Inertia::render('Rol/Index');
    })->name('roles.index');

});

// Se eliminó la llave } extra que estaba al final del código
