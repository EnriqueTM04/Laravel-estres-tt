<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alto = Categoria::where('nombre_categoria', 'Estrés Alto')->first();
        $moderado = Categoria::where('nombre_categoria', 'Estrés Moderado')->first();

        Actividad::insert([
            [
                'nombre' => 'Respiración profunda',
                'descripcion' => 'Ejercicio de respiración guiada',
                'tipo' => 'respiracion',
                'tiempo_estimado_min' => 10,
                'calificacion' => 8,
                'categoria_id' => $alto->id,
            ],
            [
                'nombre' => 'Meditación guiada',
                'descripcion' => 'Meditación para reducir ansiedad',
                'tipo' => 'meditacion',
                'tiempo_estimado_min' => 15,
                'calificacion' => 9,
                'categoria_id' => $alto->id,
            ],
            [
                'nombre' => 'Organización del tiempo',
                'descripcion' => 'Actividad cognitiva para manejo del tiempo',
                'tipo' => 'ejercicio',
                'tiempo_estimado_min' => 20,
                'calificacion' => 6,
                'categoria_id' => $moderado->id,
            ],
        ]);
    }
}
