<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaPregunta extends Model
{
    protected $table = 'respuestas_pregunta';

    protected $fillable = [
        'pregunta_id',
        'texto_respuesta',
        'valor',
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }
}
