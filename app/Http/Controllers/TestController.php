<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Paciente;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Devuelve las preguntas de un test con sus posibles respuestas.
     */
    public function preguntas(Test $test)
    {
        $test->load([
            'preguntas' => function ($q) {
                $q->orderBy('id');
            },
            'preguntas.respuestas' => function ($q) {
                // Ordenar por valor para mantener Nunca..Muy a menudo
                $q->orderBy('valor');
            },
        ]);

        $data = [
            'test_id' => $test->id,
            'preguntas' => $test->preguntas->map(function ($p) {
                return [
                    'id' => $p->id,
                    'texto' => $p->texto_pregunta,
                    'tipo' => $p->tipo,
                    'respuestas' => $p->respuestas->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'texto' => $r->texto_respuesta,
                            'valor' => (int) $r->valor,
                        ];
                    })->values(),
                ];
            })->values(),
        ];

        return response()->json($data);
    }

    /**
     * Guarda el resultado del test (nivel de estrés actual) para el paciente autenticado.
     */
    public function resultado(Request $request, Test $test)
    {
        $validated = $request->validate([
            'score' => ['required', 'integer', 'min:0'],
        ]);

        $user = $request->user();
        $paciente = Paciente::where('user_id', $user->id)->first();
        if (!$paciente) {
            return response()->json([
                'message' => 'Paciente no encontrado para el usuario autenticado',
            ], 404);
        }

        $paciente->nivel_estres_actual = $validated['score'];
        $paciente->save();

        return (new \App\Http\Resources\PacienteResource($paciente))
            ->additional([
                'message' => 'Nivel de estrés actualizado',
            ]);
    }
}
