<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = ['correo', 'password'];
    
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
}