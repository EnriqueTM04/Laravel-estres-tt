<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones';

    protected $fillable = [
        'psicologo_id',
        'paciente_id',
        'fecha',
        'hora',
        'tipo_sesion',
        'observaciones',
    ];

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
