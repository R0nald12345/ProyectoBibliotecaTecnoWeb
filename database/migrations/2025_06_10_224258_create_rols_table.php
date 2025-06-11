<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['nombre' => 'Administrador'],
            ['nombre' => 'Usuario'],
            ['nombre' => 'Bibliotecario']
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}