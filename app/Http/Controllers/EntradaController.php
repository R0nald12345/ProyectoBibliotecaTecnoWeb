<?php

namespace App\Http\Controllers;

use App\Models\entrada;
use App\Models\tipoalerta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EntradasExport;
use App\Models\Gestion;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function exportExcel(Request $request)
    {
        return Excel::download(new EntradasExport($request->inicio, $request->fin), 'entradas.xlsx');
    }


    // EntradaController.php
    public function index()
    {
        $entradas = Entrada::with(['user', 'tipoalerta', 'gestion']) // 👈 añade 'gestion'
            ->latest()
            ->paginate(10);

        return Inertia::render('Entrada/Index', [
            'entradas' => $entradas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::select('id', 'name')->get();
        $tiposAlerta = TipoAlerta::select('id', 'descripcion')->get();
        $gestiones = Gestion::select('id', 'nombre')->get(); // ✅ nuevo

        $fecha = now()->format('Y-m-d');
        $hora = now()->format('H:i');

        return Inertia::render('Entrada/Create', [
            'usuarios' => $usuarios,
            'tipos_alerta' => $tiposAlerta,
            'gestiones' => $gestiones, // ✅ enviar a la vista
            'fecha_actual' => $fecha,
            'hora_actual' => $hora,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $codigo = $request->user_id;

        // Buscar usuario
        $user = User::find($codigo);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no encontrado',
            ], 404);
        }

        // // Asignar rol si no lo tiene
        // if (!$user->hasRole('estudiante')) {
        //     $user->assignRole('estudiante');
        // }
        $hoy = Carbon::today();

        Entrada::create([
            'descripcion' => 'Entrada por código QR',
            'fecha' => $hoy,
            'hora' => Carbon::now()->toTimeString(),
            'user_id' => $user->id,
            'gestion_id' => 1,
            'tipoalerta_id' => $request->tipoalerta_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Asistencia Entrada registrada correctamente',
        ]);
    }




    /**
     * Display the specified resource.
     */
    public function show(entrada $entrada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(entrada $entrada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, entrada $entrada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        $entrada = Entrada::findOrFail($id);
        $entrada->delete();

        return redirect()->route('entrada.index')->with('success', 'Entrada eliminada correctamente.');
    }
}
