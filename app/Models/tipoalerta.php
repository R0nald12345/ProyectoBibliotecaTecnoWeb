<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAlerta extends Model
{
    protected $table = 'tipoalerta'; // si tu tabla se llama así

    protected $fillable = [
        'descripcion',
    ];
}
