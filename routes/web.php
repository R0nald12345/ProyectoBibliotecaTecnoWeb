<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HolaMundoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VerificacionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ---------------------
// Rutas de Salida
// ---------------------
Route::get('/salidas', [SalidaController::class, 'index'])->name('salida.index');
Route::get('/salidas/create', [SalidaController::class, 'create'])->name('salida.create');
Route::get('/salidas/export', [SalidaController::class, 'exportExcel'])->name('salida.export.excel');
Route::post('/salidas', [SalidaController::class, 'store'])->name('salida.store');
Route::post('/salida', [SalidaController::class, 'store'])->name('salida.store'); // duplicada con diferente URI
Route::delete('/salida/{id}', [SalidaController::class, 'destroy'])->name('salida.destroy');

// ---------------------
// Rutas de Entrada
// ---------------------
Route::get('/entrada', [EntradaController::class, 'index'])->name('entrada.index');
Route::get('/entrada/create', [EntradaController::class, 'create'])->name('entrada.create');
Route::get('/entrada/export/pdf', [EntradaController::class, 'exportPdf'])->name('entrada.export.pdf');
Route::get('/entrada/export/excel', [EntradaController::class, 'exportExcel'])->name('entrada.export.excel');
Route::post('/entrada', [EntradaController::class, 'store'])->name('entrada.store');
Route::delete('/entrada/{id}', [EntradaController::class, 'destroy'])->name('entrada.destroy');

// ---------------------
// Recursos
// ---------------------
Route::resource('gestion', GestionController::class);
Route::resource('roles', RoleController::class);
Route::resource('usuarios', UsuarioController::class);

// ---------------------
// Rutas de QR
// ---------------------
Route::get('/qr/{token}', [QRController::class, 'obtenerDatosUsuario']);
Route::get('/mi-qr', [QrController::class, 'mostrarQR'])->middleware('auth')->name('qr.mostrar');
Route::post('/qr/entrada', [QrController::class, 'registrarEntrada']);
Route::post('/qr/salida', [QrController::class, 'registrarSalida']);

// ---------------------
// Rutas protegidas por middleware
// ---------------------
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Hola Mundo
    Route::get('/hola', [HolaMundoController::class, 'index'])->name('hola');

    // Asistencia
    Route::get('/asistencia', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::get('/asistencia2', [AsistenciaController::class, 'index2'])->name('asistencia.index2');
    Route::post('/asistencia', [AsistenciaController::class, 'registrar'])->name('asistencia.registrar');
    Route::post('/storeentrada', [AsistenciaController::class, 'storeentrada'])->name('asistencia.storeentrada');
    Route::post('/storesalida', [AsistenciaController::class, 'storesalida'])->name('asistencia.storesalida');

    // Scraper
    Route::get('/scrap-estudiante', [ScraperController::class, 'scrape'])->name('scraper.scrape');

    // Dashboard de permisos
    Route::get('/permisos', function () {
        return Inertia::render('Permiso/Index');
    })->name('permisos.index');

    // Dashboard de asistencias
    Route::get('/asistencias', function () {
        return Inertia::render('Asistencia/Index');
    })->name('asistencias.dashboard');
});
