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
            'fecha'           => Carbon::now()->toDateString(),
            'hora'            => Carbon::now()->toTimeString(),
            'user_id'         => $user->id,
            'tipoalerta_id'   => 1, // o el tipo de alerta correspondiente
            'gestion_id'      => 1, // o la gestión activa
        ]);

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
