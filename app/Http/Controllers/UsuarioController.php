<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->paginate(5); // 10 por página

        return Inertia::render('Usuario/Index', [
            'usuarios' => $usuarios,
        ]);
    }


    public function create()
    {
        $roles = Role::select('id', 'name')->get();

        return Inertia::render('Usuario/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id'       => 'required|numeric|unique:users,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'celular'  => 'nullable|string|max:20',
            'role'     => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'id'       => $data['id'],
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'celular'  => $data['celular'],
        ]);

        $user->assignRole($data['role']);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        $roles = Role::select('id', 'name')->get();

        return Inertia::render('Usuario/Edit', [
            'usuario' => $usuario->load('roles'),
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $usuario->id,
            'celular'  => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'role'     => 'required|exists:roles,name',
        ]);

        $usuario->update([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'celular'  => $data['celular'],
            'password' => $data['password'] ? Hash::make($data['password']) : $usuario->password,
        ]);

        $usuario->syncRoles([$data['role']]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
