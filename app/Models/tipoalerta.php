<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAlerta extends Model
{
    protected $table = 'tipoalerta';
    protected $fillable = [
        'descripcion',
    ];
}
