<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|unique:usuarios',
            'password' => 'required|min:6',
            'rol_id' => 'required|exists:roles,id'
        ]);

        $usuario = Usuario::create([
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id
        ]);

        return response()->json($usuario, 201);
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'correo' => 'email|unique:usuarios,correo,'.$usuario->id,
            'rol_id' => 'exists:roles,id'
        ]);

        $usuario->update($request->all());
        return response()->json($usuario);
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(null, 204);
    }
}