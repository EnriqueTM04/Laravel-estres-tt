<?php

namespace Database\Seeders;

use App\Models\Paciente;
use App\Models\Psicologo;
use App\Models\Sesion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $psicologo = Psicologo::first();

        foreach (Paciente::all() as $paciente) {
            Sesion::create([
                'psicologo_id' => $psicologo->id,
                'paciente_id' => $paciente->id,
                'fecha' => now()->subDays(rand(1, 15))->toDateString(),
                'hora' => '10:00',
                'tipo_sesion' => 'presencial',
                'observaciones' => 'Sesión de seguimiento inicial',
            ]);
        }
    }
}
