<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'user_id',
        'psicologo_id',
        'edad',
        'sexo',
        'nivel_estres_actual',
        'semestre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }
    
}
