<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\GestionController;

use App\Http\Controllers\HolaMundoController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\QrController;
// use App\Http\Controllers\RoleController; // Removed to avoid class name conflict
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


Route::get('/salidas', [SalidaController::class, 'index'])->name('salida.index');
Route::get('/salidas/export', [SalidaController::class, 'exportExcel'])->name('salida.export.excel');
Route::get('/salidas/create', [SalidaController::class, 'create'])->name('salida.create');
Route::post('/salidas', [SalidaController::class, 'store'])->name('salida.store');
Route::delete('/salida/{id}', [SalidaController::class, 'destroy'])->name('salida.destroy');



Route::get('/entrada/export/pdf', [EntradaController::class, 'exportPdf'])->name('entrada.export.pdf');
Route::get('/entrada/export/excel', [EntradaController::class, 'exportExcel'])->name('entrada.export.excel');
Route::get('/entrada/create', [EntradaController::class, 'create'])->name('entrada.create');
Route::get('/entrada', [EntradaController::class, 'index'])->name('entrada.index');
Route::delete('/entrada/{id}', [EntradaController::class, 'destroy'])->name('entrada.destroy');


Route::post('/entrada', [EntradaController::class, 'store'])->name('entrada.store');
Route::post('/salida', [SalidaController::class, 'store'])->name('salida.store');


Route::resource('gestion', GestionController::class);
Route::resource('roles', RoleController::class);
Route::resource('usuarios', UsuarioController::class);

Route::get('/qr/{token}', [QRController::class, 'obtenerDatosUsuario']);
Route::get('/mi-qr', [QRController::class, 'mostrarQR'])->middleware('auth')->name('qr.mostrar');
Route::post('/qr/entrada', [QRController::class, 'registrarEntrada']);
Route::post('/qr/salida', [QRController::class, 'registrarSalida']);
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
    Route::get('/asistencia2', [AsistenciaController::class, 'index2'])->name('asistencia.index2');
    Route::post('/asistencia', [AsistenciaController::class, 'registrar'])->name('asistencia.registrar');
    Route::get('/scrap-estudiante', [ScraperController::class, 'scrape'])->name('scraper.scrape');

    Route::post('/storeentrada', [AsistenciaController::class, 'storeentrada'])->name('asistencia.storeentrada');
    Route::post('/storesalida', [AsistenciaController::class, 'storesalida'])->name('asistencia.storesalida');

    // Rutas para la gestión de permisos
    Route::get('/permisos', function () {
        return Inertia::render('Permiso/Index');
    })->name('permisos.index');

    // Ruta para el dashboard de asistencias
    Route::get('/asistencias', function () {
        return Inertia::render('Asistencia/Index');
    })->name('asistencias.dashboard');
});
