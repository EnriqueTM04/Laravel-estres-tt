<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'paciente_id',
        'test_id',
        'calificacion_general',
        'nivel_estres_actual',
        'fecha_realizacion',
    ];

    public function historial() {
        return $this->hasMany(HistorialCalificacion::class);
    }
}
