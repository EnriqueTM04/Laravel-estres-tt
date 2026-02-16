<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'tiempo_estimado_min',
        'calificacion',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
