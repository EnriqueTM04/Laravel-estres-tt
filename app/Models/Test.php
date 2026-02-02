<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'tests';

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
}
