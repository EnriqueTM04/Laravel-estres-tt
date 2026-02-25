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
            ],
            [
                'nombre_categoria' => 'Estrés Moderado',
            ],
            [
                'nombre_categoria' => 'Estrés Alto',
            ],
        ]);
    }
}
