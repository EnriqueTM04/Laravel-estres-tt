<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psicologo extends Model
{
    /** @use HasFactory<\Database\Factories\PsicologoFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cedula_profesional',
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }
}
