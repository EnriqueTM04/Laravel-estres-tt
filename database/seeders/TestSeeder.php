<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Test::create([
            'nombre_test' => 'Escala de Estrés Percibido (PSS-14)',
            'descripcion' => 'Evalúa el nivel de estrés percibido durante el último mes',
        ]);
    }
}
