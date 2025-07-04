<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Asistencia;
use App\Models\entrada;
use App\Models\User;
use Inertia\Inertia;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index()
    {
        return Inertia::render('Asistencia/Scan');
    }

    public function index2()
    {
        return Inertia::render('Asistencia/Scan2');
    }

    public function registrar(Request $request)
    {
        $codigo = $request->codigo;

        // Buscar usuario por ID (usando el código como ID)
        $user = User::find($codigo);
        dd($user,$request->all());
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Usuario no encontrado'], 404);
        }


        // Asignar rol estudiante si no lo tiene
        if (!$user->hasRole('estudiante')) {
            $user->assignRole('estudiante');
        }

        $hoy = Carbon::today();

        // Verificar si ya registró entrada hoy
        $existeHoy = Entrada::where('user_id', $user->id)
            ->whereDate('fecha', $hoy)
            ->exists();

        if ($existeHoy) {
            return response()->json(['status' => 'info', 'message' => 'Ya registró asistencia hoy']);
        }

        // Registrar nueva entrada
        entrada::create([
            'descripcion' => 'Entrada por código QR',
            'fecha' => $hoy,
            'hora' => Carbon::now()->toTimeString(),
            'user_id' => $user->id,
            'gestion_id' => $request->gestion_id,      // debe enviarse desde el frontend
            'tipoalerta_id' => $request->tipoalerta_id, // también desde el frontend
        ]);

        return response()->json(['status' => 'success', 'message' => 'Asistencia registrada']);
    }
}
