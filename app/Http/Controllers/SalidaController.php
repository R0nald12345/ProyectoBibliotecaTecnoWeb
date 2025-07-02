<?php

namespace App\Http\Controllers;

use App\Models\salida;
use App\Models\tipoalerta;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'user_id' => 'required|exists:users,id',
            'tipoalerta' => 'required|string|max:255', // Nuevo campo
        ]);

        // Crear tipo de alerta
        $tipoAlerta = tipoalerta::create([
            'descripcion' => $data['tipoalerta'],
        ]);

        // Crear entrada con el nuevo tipo de alerta
        salida::create([
            'descripcion'     => $data['descripcion'],
            'fecha'           => $data['fecha'],
            'hora'            => $data['hora'],
            'user_id'         => $data['user_id'],
            'tipoalerta_id'   => $tipoAlerta->id,
        ]);

        return redirect()->route('salida.index')->with('success', 'Salidad creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(salida $salida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(salida $salida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, salida $salida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(salida $salida)
    {
        //
    }
}
