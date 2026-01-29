<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::insert([
            [
                'nombre_categoria' => 'Estrés Bajo',
                'calificacion_minima' => 0,
                'calificacion_maxima' => 19,
            ],
            [
                'nombre_categoria' => 'Estrés Moderado',
                'calificacion_minima' => 20,
                'calificacion_maxima' => 25,
            ],
            [
                'nombre_categoria' => 'Estrés Alto',
                'calificacion_minima' => 26,
                'calificacion_maxima' => 56,
            ],
        ]);
    }
}
