<?php

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\Paciente;
use App\Models\ProgresoActividad;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgresoActividadSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Paciente::all();
        $actividades = Actividad::all();

        foreach ($pacientes as $paciente) {

            $actividadesAsignadas = $actividades->random(rand(2, 3));

            foreach ($actividadesAsignadas as $actividad) {

                $estado = collect(['pendiente', 'en_progreso', 'completado'])->random();

                // Progreso coherente con el estado
                $progreso = match ($estado) {
                    'pendiente' => rand(0, 20),
                    'en_progreso' => rand(30, 70),
                    'completado' => rand(80, 100),
                };

                ProgresoActividad::create([
                    'paciente_id' => $paciente->id,
                    'actividad_id' => $actividad->id,
                    'fecha' => Carbon::now()->subDays(rand(1, 14)),
                    'progreso_porcentaje' => $progreso,
                    'comentarios' => $estado === 'completado'
                        ? 'Actividad completada con buen desempeño'
                        : 'Actividad en seguimiento',
                    'estado' => $estado,
                ]);
            }
        }
    }
}