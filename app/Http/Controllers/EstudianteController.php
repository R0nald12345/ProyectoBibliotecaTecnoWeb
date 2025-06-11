<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::all();
        return Inertia::render('Estudiantes/Index', [
            'estudiantes' => $estudiantes
        ]);
    }

    public function create()
    {
        return Inertia::render('Estudiantes/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reg' => 'required|integer|unique:estudiantes,reg',
            'nombre' => 'required|string',
            'carrera' => 'required|string',
            'fecha_emision' => 'required|date',
            'codigo' => 'required|string|unique:estudiantes,codigo',
        ]);

        Estudiante::create($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado correctamente.');
    }

    public function show($reg)
    {
        $estudiante = Estudiante::findOrFail($reg);
        return Inertia::render('Estudiantes/Show', [
            'estudiante' => $estudiante
        ]);
    }

    public function edit($reg)
    {
        $estudiante = Estudiante::findOrFail($reg);
        return Inertia::render('Estudiantes/Edit', [
            'estudiante' => $estudiante
        ]);
    }

    public function update(Request $request, $reg)
    {
        $estudiante = Estudiante::findOrFail($reg);

        $request->validate([
            'nombre' => 'required|string',
            'carrera' => 'required|string',
            'fecha_emision' => 'required|date',
            'codigo' => 'required|string|unique:estudiantes,codigo,' . $reg . ',reg',
        ]);

        $estudiante->update($request->all());

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy($reg)
    {
        $estudiante = Estudiante::findOrFail($reg);
        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado correctamente.');
    }
}