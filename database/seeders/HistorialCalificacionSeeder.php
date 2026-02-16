<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calificacion;
use App\Models\HistorialCalificacion;
use Carbon\Carbon;

class HistorialCalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $calificaciones = Calificacion::all();

        foreach ($calificaciones as $calificacion) {

            // Simulamos 8 semanas de evolución
            for ($week = 0; $week < 8; $week++) {

                $valor = rand(4, 9);

                HistorialCalificacion::create([
                    'calificacion_id' => $calificacion->id,
                    'fecha' => Carbon::now()->subWeeks(7 - $week),
                    'valor' => $valor,
                    'categoria' => $this->categoriaPorValor($valor),
                ]);
            }
        }
    }

    private function categoriaPorValor($valor)
    {
        if ($valor <= 4) return 'Bajo';
        if ($valor <= 7) return 'Moderado';
        return 'Alto';
    }
}
