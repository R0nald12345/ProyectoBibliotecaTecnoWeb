<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table = 'gestion';
    protected $fillable = ['nombre'];
    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }
    public function salidas()
    {
        return $this->hasMany(Salida::class);
    }
}
