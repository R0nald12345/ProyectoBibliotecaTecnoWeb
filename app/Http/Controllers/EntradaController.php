<?php

namespace App\Http\Controllers;

use App\Models\entrada;
use App\Models\tipoalerta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $entradas = entrada::with(['user', 'tipoalerta'])->latest()->paginate(10);

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

        $fecha = now()->format('Y-m-d');
        $hora = now()->format('H:i');

        return Inertia::render('Entrada/Create', [
            'usuarios' => $usuarios,
            'tipos_alerta' => $tiposAlerta,
            'fecha_actual' => $fecha,
            'hora_actual' => $hora,
        ]);
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
            'tipoalerta_id' => 'required|exists:tipoalerta,id',
        ]);

        Entrada::create($data);

        return redirect()->route('entrada.index')->with('success', 'Entrada creada correctamente.');
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
