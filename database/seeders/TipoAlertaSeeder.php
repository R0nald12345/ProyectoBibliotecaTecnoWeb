<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAlertaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipoalerta')->insert([
            ['descripcion' => 'aceptado', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'rechazado', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
