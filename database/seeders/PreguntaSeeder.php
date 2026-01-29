<?php

namespace Database\Seeders;

use App\Models\Pregunta;
use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $test = Test::first();

        $preguntas = [
            'En el último mes, ¿con qué frecuencia has estado afectado por algo que ocurrió inesperadamente?',
            'En el último mes, ¿con qué frecuencia te has sentido incapaz de controlar las cosas importantes de tu vida?',
            'En el último mes, ¿con qué frecuencia te has sentido nervioso o estresado?',
            'En el último mes, ¿con qué frecuencia has manejado con éxito los pequeños problemas irritantes de la vida?',
            'En el último mes, ¿con qué frecuencia has sentido que has afrontado efectivamente los cambios importantes que han ocurrido en tu vida?',
            'En el último mes, ¿con qué frecuencia has estado seguro sobre tu capacidad para manejar tus problemas personales?',
            'En el último mes, ¿con qué frecuencia has sentido que las cosas te van bien?',
            'En el último mes, ¿con qué frecuencia has sentido que no podías afrontar todas las cosas que tenías que hacer?',
            'En el último mes, ¿con qué frecuencia has podido controlar las dificultades de tu vida?',
            'En el último mes, ¿con qué frecuencia has sentido que tenías todo bajo control?',
            'En el último mes, ¿con qué frecuencia has estado enfadado porque las cosas que te han ocurrido estaban fuera de tu control?',
            'En el último mes, ¿con qué frecuencia has pensado sobre las cosas que te faltan por hacer?',
            'En el último mes, ¿con qué frecuencia has podido controlar la forma de pasar el tiempo?',
            'En el último mes, ¿con qué frecuencia has sentido que las dificultades se acumulan tanto que no puedes superarlas?',
        ];

        foreach ($preguntas as $texto) {
            Pregunta::create([
                'test_id' => $test->id,
                'texto_pregunta' => $texto,
                'tipo' => 'escala',
            ]);
        }
    }
}
