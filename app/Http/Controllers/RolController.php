<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:roles,nombre'
        ]);

        $rol = Rol::create([
            'nombre' => $request->nombre
        ]);

        return response()->json($rol, 201);
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'nombre' => 'required|unique:roles,nombre,' . $rol->id
        ]);

        $rol->update([
            'nombre' => $request->nombre
        ]);

        return response()->json($rol);
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return response()->json(null, 204);
    }
}