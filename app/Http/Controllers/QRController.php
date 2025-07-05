<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\entrada;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
class QRController extends Controller
{
   public function registrarEntrada($token)
{
    $user = User::where('qr_token', $token)->firstOrFail();

    // Registrar nueva entrada
    entrada::create([
        'descripcion'     => 'Entrada vía QR',
        'fecha'           => now()->toDateString(),
        'hora'            => now()->toTimeString(),
        'user_id'         => $user->id,
        'tipoalerta_id'   => 1, // o el tipo correspondiente
        'gestion_id'      => 1,
    ]);

    // Si es una petición AJAX, retornar JSON
    if (request()->wantsJson() || request()->ajax()) {
        return response()->json([
            'mensaje' => 'Asistencia registrada correctamente.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'celular' => $user->celular,
            ]
        ]);
    }

    // Si no, renderizar vista Inertia como antes
    return Inertia::render('QR/Confirmacion', [
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'celular' => $user->celular,
        ],
        'mensaje' => 'Entrada registrada correctamente.',
    ]);
}

    public function mostrarQR()
{
    return Inertia::render('GenerarQR/GenerarQR', [
        'user' => auth()->user(),
    ]);
}
}
