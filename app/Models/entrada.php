<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class entrada extends Model
{

    protected $table = 'entrada';

    protected $fillable = [
        'descripcion',
        'fecha',
        'hora',
        'user_id',
        'tipoalerta_id',
        'gestion_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tipoalerta()
    {
        return $this->belongsTo(tipoalerta::class);
    }
    // Entrada.php (modelo)
    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

}
