<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\entrada;
use App\Models\salida;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class QRController extends Controller
{
    public function obtenerDatosUsuario($token)
    {
        $user = User::where('qr_token', $token)->firstOrFail();

        // Solo devolver los datos del usuario sin crear entrada
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'celular' => $user->celular,
            'ci' => $user->ci ?? null,
            'carrera' => $user->carrera ?? null,
            'semestre' => $user->semestre ?? null,
            'foto' => $user->foto ?? null,
            'qr_token' => $user->qr_token,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];

        // Si es una petición AJAX, retornar JSON

        return response()->json([
            'success' => true,
            'mensaje' => 'Datos obtenidos correctamente.',
            'user' => $userData
        ]);
    }

    // Método separado para registrar entrada
    public function registrarEntrada(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipo' => 'required|in:entrada,salida',
            'descripcion' => 'nullable|string',
        ]);

        $descripcion = $request->descripcion ?? ($request->tipo === 'entrada' ? 'Entrada vía QR' : 'Salida vía QR');
        $tipoAlertaId = $request->tipo === 'entrada' ? 1 : 2;

        $gestion = \App\Models\Gestion::where('estado', 'activo')->first();
        if (!$gestion) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No hay una gestión activa configurada.',
            ], 400);
        }

        // Validar si ya existe una entrada activa (estado=true) para este usuario y gestión
        $entradaActiva = entrada::where('user_id', $request->user_id)
            ->where('gestion_id', $gestion->id)
            ->where('estado', true)
            ->first();
        if ($entradaActiva) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Ya existe una entrada activa para este usuario. Debe registrar una salida antes de una nueva entrada.',
            ], 400);
        }

        entrada::create([
            'descripcion' => $descripcion,
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
            'user_id' => $request->user_id,
            'tipoalerta_id' => $tipoAlertaId,
            'gestion_id' => $gestion->id,
            'estado' => true,
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => ucfirst($request->tipo) . ' registrada correctamente.',
            'tipo' => $request->tipo,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    // Método separado para registrar salida
    public function registrarSalida(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'nullable|string',
        ]);

        $descripcion = $request->descripcion ?? 'Salida vía QR';

        $gestion = \App\Models\Gestion::where('estado', 'activo')->first();
        if (!$gestion) {
            return response()->json([
                'success' => false,
                'mensaje' => 'No hay una gestión activa configurada.',
            ], 400);
        }

        
        // Buscar la última entrada activa (estado=true) para este usuario y gestión
        $entradaActiva = entrada::where('user_id', $request->user_id)
        ->where('gestion_id', $gestion->id)
        ->where('estado', true)
        ->latest('fecha')
        ->first();
        $entradaActiva->estado = false;
        $entradaActiva->save();

        dump('Entrada', $entradaActiva);
    


        salida::create([
            'descripcion' => $descripcion,
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
            'user_id' => $request->user_id,
            'tipoalerta_id' => 1,
            'gestion_id' => $gestion->id,
            'estado' => true,
        ]);

        return response()->json([
            'success' => true,
            'mensaje' => 'Salida registrada correctamente.',
            'tipo' => 'salida',
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    public function mostrarQR()
    {
        return Inertia::render('GenerarQR/GenerarQR', [
            'user' => Auth::user(),

        ]);
    }
}
