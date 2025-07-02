<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear el permiso
        $permission = Permission::firstOrCreate(['name' => 'Editar']);

        // Crear el rol y asignarle el permiso
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo($permission);

        $role = Role::firstOrCreate(['name' => 'administrativo']);
        $role = Role::firstOrCreate(['name' => 'docente']);
        $role = Role::firstOrCreate(['name' => 'estudiante']);
        $role = Role::firstOrCreate(['name' => 'visita']);

        // Crear el usuario y asignarle el rol
        $user = User::firstOrCreate(
            ['email' => 'daniel@gmail.com'],
            ['name' => 'castedo daniel', 'password' => bcrypt('12345678')]
        );
        $user->assignRole('admin');

        // Crear el usuario y asignarle el rol
        $user = User::firstOrCreate(
            ['email' => 'administrador@gmail.com'],
            ['name' => 'ronald camino', 'password' => bcrypt('12345678')]
        );
        $user->assignRole('administrativo');

        // Crear el usuario y asignarle el rol
        $user = User::firstOrCreate(
            ['email' => 'docente@gmail.com'],
            ['name' => 'Mirian Mendez', 'password' => bcrypt('12345678')]
        );
        $user->assignRole('docente');

        // Crear el usuario y asignarle el rol
        $user = User::firstOrCreate(
            ['email' => 'micaelcardona@gmail.com'],
            ['name' => 'micael cardona ', 'password' => bcrypt('12345678')]
        );
        $user->assignRole('estudiante');


        $user = User::firstOrCreate(
            ['email' => 'visita@gmail.com'],
            ['name' => 'visitante', 'password' => bcrypt('12345678')]
        );
        $user->assignRole('visita');
    }
}
