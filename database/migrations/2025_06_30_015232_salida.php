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
        Schema::create('salida', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tipoalerta_id');
            $table->unsignedBigInteger('gestion_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gestion_id')->references('id')->on('gestion')->onDelete('cascade');
            $table->foreign('tipoalerta_id')->references('id')->on('tipoalerta')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salida');
    }
};
