<?php

namespace Database\Seeders;

use App\Models\Pregunta;
use App\Models\RespuestaPregunta;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RespuestaPreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapeos de valor según especificación:
        // Ítems directos: 1,2,3,8,11,12,14 => 0..4
        // Ítems invertidos: 4,5,6,7,9,10,13 => 4..0
        $directos = [1, 2, 3, 8, 11, 12, 14];
        $invertidos = [4, 5, 6, 7, 9, 10, 13];

        $opcionesDirectas = [
            ['Nunca', 0],
            ['Casi nunca', 1],
            ['De vez en cuando', 2],
            ['A menudo', 3],
            ['Muy a menudo', 4],
        ];

        $opcionesInvertidas = [
            ['Nunca', 4],
            ['Casi nunca', 3],
            ['De vez en cuando', 2],
            ['A menudo', 1],
            ['Muy a menudo', 0],
        ];

        // Regenerar respuestas limpiamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('respuestas_pregunta')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Asignar valores por pregunta
        foreach (Pregunta::orderBy('id')->get() as $pregunta) {
            $id = $pregunta->id;
            $opciones = in_array($id, $invertidos, true)
                ? $opcionesInvertidas
                : $opcionesDirectas;

            foreach ($opciones as [$texto, $valor]) {
                RespuestaPregunta::create([
                    'pregunta_id' => $id,
                    'texto_respuesta' => $texto,
                    'valor' => $valor,
                ]);
            }
        }
    }
}
