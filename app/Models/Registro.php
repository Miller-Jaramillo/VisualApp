<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $fillable = ['nombre_registro', 'descripcion', 'tipo', 'fecha_inicial', 'fecha_final', 'archivo_xlsx', 'user_id', 'nombre_usuario'];




    public function reportesAccidentes()
    {
        return $this->hasMany(Archivo::class);
    }



    public function usuario()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
