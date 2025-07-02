<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipoalerta extends Model
{
    protected $table = 'tipoalerta';

    protected $fillable = [
       'descripcion'
    ];
}
