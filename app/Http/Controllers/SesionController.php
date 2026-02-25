<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $week = $request->query('week');
        $user = auth()->user();
        $psicologo = $user->psicologo;
        $psicologoId = $psicologo->id;

        $start = Carbon::parse($week)->startOfWeek(Carbon::MONDAY);
        $end   = Carbon::parse($week)->endOfWeek(Carbon::FRIDAY);

        $sesiones = Sesion::with(['paciente.user'])
            ->where('psicologo_id', $psicologoId)
            ->whereBetween('fecha', [$start->toDateString(), $end->toDateString()])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get();

        return response()->json($sesiones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'psicologo_id' => ['required', 'exists:psicologos,id'],
            'fecha' => ['required', 'date'],
            'hora' => ['required', 'regex:/^\d{2}:\d{2}$/'], // HH:mm
            'observaciones' => ['nullable', 'string'],
        ]);

        $user = auth()->user();
        $paciente = $user?->paciente;

        if (!$paciente) {
            return response()->json([
                'message' => 'Solo pacientes pueden agendar citas'
            ], 403);
        }

        $horaNormalizada = Carbon::createFromFormat('H:i', $request->hora)
            ->format('H:i:s');

        $exists = Sesion::where('psicologo_id', $request->psicologo_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $horaNormalizada)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Ese horario ya esta ocupado'
            ], 422);
        }

        $sesion = Sesion::create([
            'psicologo_id' => $request->psicologo_id,
            'paciente_id' => $paciente->id,
            'fecha' => $request->fecha,
            'hora' => $horaNormalizada,
            'tipo_sesion' => null,
            'observaciones' => $request->observaciones,
        ]);

        return response()->json([
            'message' => 'Cita agendada correctamente',
            'sesion' => $sesion,
        ], 201);
    }

    /**
     * Return booked times for a psychologist on a date.
     */
    public function bookedTimes(Request $request)
    {
        $request->validate([
            'psicologo_id' => ['required', 'exists:psicologos,id'],
            'fecha' => ['required', 'date'],
        ]);

        $times = Sesion::where('psicologo_id', $request->psicologo_id)
            ->where('fecha', $request->fecha)
            ->orderBy('hora')
            ->pluck('hora')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->values();

        return response()->json([
            'data' => $times,
        ]);
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
    public function update(Request $request, Sesion $sesion)
    {
        $request->validate([
            'hora' => ['required', 'regex:/^\d{2}:\d{2}$/'], // HH:mm
            'fecha' => ['sometimes', 'date'],
            'modalidad' => ['in:virtual,presencial'],
            'notas' => ['nullable', 'string'],
        ]);

        // Normalizar hora a HH:mm:ss
        $horaNormalizada = Carbon::createFromFormat('H:i', $request->hora)
            ->format('H:i:s');

        $sesion->update([
            'hora' => $horaNormalizada,
            'fecha' => $request->fecha ?? $sesion->fecha,
            'tipo_sesion' => $request->modalidad,
            'observaciones' => $request->notas ?? $sesion->observaciones,
        ]);

        return response()->json([
            'message' => 'Cita actualizada correctamente',
            'sesion' => $sesion->fresh(['paciente.user']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sesion $sesion)
    {
        if ($sesion->psicologo_id !== auth()->user()->psicologo->id) {
            return response()->json([
                'message' => 'No autorizado'
            ], 403);
        }

        $sesion->delete();

        return response()->json([
            'message' => 'Sesión eliminada correctamente'
        ], 200);
    }
}
