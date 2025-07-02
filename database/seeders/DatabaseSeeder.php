<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear permiso
        $permission = Permission::firstOrCreate(['name' => 'Editar']);

        // Crear roles
        Role::firstOrCreate(['name' => 'admin'])->givePermissionTo($permission);
        Role::firstOrCreate(['name' => 'administrativo']);
        Role::firstOrCreate(['name' => 'docente']);
        Role::firstOrCreate(['name' => 'estudiante']);
        Role::firstOrCreate(['name' => 'visita']);

        // Crear usuarios con IDs manuales
        $usuarios = [
            ['id' => '1', 'email' => 'daniel@gmail.com', 'name' => 'castedo daniel', 'role' => 'admin'],
            ['id' => '2', 'email' => 'administrador@gmail.com', 'name' => 'ronald camino', 'role' => 'administrativo'],
            ['id' => '3', 'email' => 'docente@gmail.com', 'name' => 'Mirian Mendez', 'role' => 'docente'],
            ['id' => '4', 'email' => 'micaelcardona@gmail.com', 'name' => 'micael cardona', 'role' => 'estudiante'],
            ['id' => '5', 'email' => 'visita@gmail.com', 'name' => 'visitante', 'role' => 'visita'],
        ];

        foreach ($usuarios as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'password' => bcrypt('12345678'),
                ]
            );
            $user->assignRole($data['role']);
        }

         $this->call(TipoAlertaSeeder::class);
    }
}
