<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table = 'gestion'; // 👈 importante

    protected $fillable = [
        'nombre',
        'estado'
    ];
}
