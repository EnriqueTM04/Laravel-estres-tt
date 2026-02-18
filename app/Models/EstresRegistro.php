<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstresRegistro extends Model
{
    use HasFactory;

    protected $table = 'estres_registros';

    protected $fillable = [
        'paciente_id',
        'score',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
