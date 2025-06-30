<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GestionController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::all();
        return Inertia::render('Gestion/Index', ['gestiones' => $gestiones]);
    }

    public function create()
    {
        return Inertia::render('Gestion/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Gestion::create($request->all());

        return redirect()->route('gestion.index')->with('success', 'Gestión creada correctamente.');
    }

    public function edit(Gestion $gestion)
    {
        return Inertia::render('Gestion/Edit', ['gestion' => $gestion]);
    }

    public function update(Request $request, Gestion $gestion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $gestion->update($request->all());

        return redirect()->route('gestion.index')->with('success', 'Gestión actualizada correctamente.');
    }

    public function destroy(Gestion $gestion)
    {
        $gestion->delete();

        return redirect()->route('gestion.index')->with('success', 'Gestión eliminada con éxito');
    }
}
