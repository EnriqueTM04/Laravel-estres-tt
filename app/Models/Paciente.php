<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }
}
