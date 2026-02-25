<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Paciente;
use App\Models\Test;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $test = Test::first();

        $pacientes = Paciente::all();

        foreach ($pacientes as $paciente) {

            for ($i = 0; $i < 3; $i++) {

                Calificacion::create([
                    'paciente_id' => $paciente->id,
                    'test_id' => $test->id,
                    'fecha_realizacion' => Carbon::now()->subWeeks(rand(1, 12)),
                    'calificacion_general' => rand(4, 40),
                    'categoria' => 'bajo', 
                ]);

            }
        }
    }
}