<?php

namespace App\Http\Controllers;

use App\Models\tipoalerta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoalertaController extends Controller
{
    public function index()
    {
        $alertas = tipoalerta::all();
        return Inertia::render('Alertas/Index', ['alertas' => $alertas]);
    }

    public function create()
    {
        return Inertia::render('Alertas/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        tipoalerta::create($request->only('descripcion'));

        return redirect()->route('tipoalerta.index')->with('success', 'Tipo de alerta creado correctamente.');
    }

    public function edit(tipoalerta $tipoalerta)
    {
        return Inertia::render('Alertas/Edit', ['alerta' => $tipoalerta]);
    }

    public function update(Request $request, tipoalerta $tipoalerta)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $tipoalerta->update($request->only('descripcion'));

        return redirect()->route('tipoalerta.index')->with('success', 'Tipo de alerta actualizado correctamente.');
    }

    public function destroy(tipoalerta $tipoalerta)
    {
        $tipoalerta->delete();

        return redirect()->route('tipoalerta.index')->with('success', 'Tipo de alerta eliminado con éxito.');
    }
}
