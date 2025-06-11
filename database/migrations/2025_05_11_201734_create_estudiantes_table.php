<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('estudiantes', function (Blueprint $table) {
        $table->integer('reg')->primary(); // Clave primaria
        $table->string('nombre');
        $table->string('carrera');
        $table->date('fecha_emision');
        $table->string('codigo')->unique(); // Código para el QR
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
