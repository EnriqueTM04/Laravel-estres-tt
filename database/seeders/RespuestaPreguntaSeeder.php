<?php

namespace Database\Seeders;

use App\Models\Pregunta;
use App\Models\RespuestaPregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RespuestaPreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opciones = [
            ['Nunca', 0],
            ['Casi nunca', 1],
            ['De vez en cuando', 2],
            ['A menudo', 3],
            ['Muy a menudo', 4],
        ];

        foreach (Pregunta::all() as $pregunta) {
            foreach ($opciones as [$texto, $valor]) {
                RespuestaPregunta::create([
                    'pregunta_id' => $pregunta->id,
                    'texto_respuesta' => $texto,
                    'valor' => $valor,
                ]);
            }
        }
    }
}
