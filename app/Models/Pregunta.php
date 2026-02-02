<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';

    protected $fillable = [
        'test_id',
        'texto_pregunta',
        'tipo',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaPregunta::class, 'pregunta_id');
    }
}
