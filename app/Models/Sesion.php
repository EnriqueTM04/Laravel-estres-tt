<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    protected $table = 'sesiones';

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
