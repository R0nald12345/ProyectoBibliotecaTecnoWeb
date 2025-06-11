<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $primaryKey = 'reg';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'reg',
        'nombre',
        'carrera',
        'fecha_emision',
        'codigo',
    ];
}