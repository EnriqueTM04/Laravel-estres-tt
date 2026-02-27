<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoActividad extends Model
{
    protected $table = 'progreso_actividad';

    protected $fillable = [
        'actividad_id',
        'paciente_id',
        'fecha',
        'progreso_porcentaje',
        'estado',
    ];

    public function actividad() {
        return $this->belongsTo(Actividad::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
