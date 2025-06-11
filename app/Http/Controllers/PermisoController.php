<?php


namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::all();
        return response()->json($permisos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permisos'
        ]);

        $permiso = Permiso::create($request->all());
        return response()->json($permiso, 201);
    }

    public function show(Permiso $permiso)
    {
        return response()->json($permiso);
    }

    public function update(Request $request, Permiso $permiso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permisos,nombre,' . $permiso->id
        ]);

        $permiso->update($request->all());
        return response()->json($permiso);
    }

    public function destroy(Permiso $permiso)
    {
        $permiso->delete();
        return response()->json(null, 204);
    }
}