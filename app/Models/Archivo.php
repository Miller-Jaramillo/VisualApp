<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    protected $table = 'archivos';

    protected $fillable = [
        'fecha', 'direccion', 'barrio', 'comuna', 'codigo_postal', 'edad', 'genero', 'tipo_victima', 'clase_accidente', 'caso_accidente', 'lesion', 'hipotesis', 'registro_id',
    'estado_victima',
    'dia',
    'hora',
    'area',
    'sector',
    'condicion_climatica',
    'superficie_rodadura',
    'geometria' ,
    'estado_via',
    'condicion'
];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }
}
