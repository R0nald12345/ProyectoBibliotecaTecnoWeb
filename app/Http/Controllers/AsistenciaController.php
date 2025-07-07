<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Asistencia;
use App\Models\entrada;
use App\Models\salida;
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

    public function storeentrada(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'user_id' => 'required|exists:users,id',
            'tipoalerta_id' => 'required|exists:tipoalerta,id', // 👈 corregido también
            'gestion_id' => 'required|exists:gestion,id',
        ]);

        entrada::create([
            'descripcion' => $request->input('descripcion'),
            'fecha' => $request->input('fecha'),
            'hora' => $request->input('hora'),
            'user_id' => $request->input('user_id'),
            'tipoalerta_id' => $request->input('tipoalerta_id'),
            'gestion_id' => $request->input('gestion_id'),
        ]);

        return redirect()->route('entrada.index')->with('success', 'Asistencia Entrada registrada correctamente');
    }

    public function storesalida(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'user_id' => 'required|exists:users,id',
            'tipoalerta_id' => 'required|exists:tipoalerta,id',
            'gestion_id' => 'required|exists:gestion,id',
        ]);

        salida::create([
            'descripcion' => $request->input('descripcion'),
            'fecha' => $request->input('fecha'),
            'hora' => $request->input('hora'),
            'user_id' => $request->input('user_id'),
            'tipoalerta_id' => $request->input('tipoalerta_id'),
            'gestion_id' => $request->input('gestion_id'),
        ]);

        return redirect()->route('salida.index')->with('success', 'Asistencia Entrada registrada correctamente');
    }
}
