<?php

namespace App\Http\Controllers;

use App\Http\Resources\PacienteCollection;
use App\Models\Calificacion;
use App\Models\Paciente;
use App\Models\Sesion;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->input('role') === 'psicologo') {
            $user = auth()->user();
            $psicologo = $user->psicologo;
            $totalSesionesProximas = Sesion::whereHas('paciente', function ($q) use ($psicologo) {
                $q->where('psicologo_id', $psicologo->id);
            })
                ->where('fecha', '>', now())
                ->count();

            $pacientes = $psicologo->pacientes()
                ->with([
                    'user',
                    'ultimaSesion',
                    'progresoActividad',
                ])
                ->get();

            return (new PacienteCollection($pacientes))
                ->additional([
                    'sesiones_proximas' => $totalSesionesProximas
                ]);
        }
    }

    /**
     * Devuelve el historial de niveles de estrés del paciente autenticado.
     */
    public function estresRegistros(Request $request)
    {
        $user = $request->user();
        $paciente = Paciente::where('user_id', $user->id)->first();
        if (!$paciente) {
            return response()->json([
                'message' => 'Paciente no encontrado para el usuario autenticado',
            ], 404);
        }

        $puntos = $paciente->calificaciones()
            ->orderBy('fecha_realizacion', 'asc')
            ->get()
            ->map(function (Calificacion $calificacion) {
                return [
                    'score' => (int) round($calificacion->calificacion_general),
                    'created_at' => optional($calificacion->fecha_realizacion)->toDateString(),
                ];
            });

        $nivelActual = $paciente->nivel_estres_actual;
        if ($nivelActual !== null && $nivelActual > 0) {
            $puntos->push([
                'score' => (int) round($nivelActual),
                'created_at' => now()->toIso8601String(),
            ]);
        }

        return response()->json([
            'data' => $puntos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
