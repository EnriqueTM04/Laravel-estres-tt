<?php

namespace Database\Seeders;

use App\Models\EstresRegistro;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class EstresRegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener un paciente para agregar registros
        $paciente = Paciente::first();

        if (!$paciente) {
            $this->command->warn('No hay pacientes en la base de datos. Ejecuta PacienteSeeder primero.');
            return;
        }

        // Crear registros de estrés para los últimos 7 días con scores variados
        $baseDate = now()->startOfDay();
        $scores = [15, 20, 18, 25, 22, 28, 30]; // Scores de ejemplo

        foreach ($scores as $index => $score) {
            EstresRegistro::create([
                'paciente_id' => $paciente->id,
                'score' => $score,
                'created_at' => $baseDate->clone()->subDays(6 - $index),
                'updated_at' => $baseDate->clone()->subDays(6 - $index),
            ]);
        }

        $this->command->info('Registros de estrés creados exitosamente.');
    }
}
