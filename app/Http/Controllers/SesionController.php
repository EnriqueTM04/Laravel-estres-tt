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
            'modalidad' => ['sometimes', 'in:online,presencial'],
            'notas' => ['nullable', 'string'],
        ]);

        // Normalizar hora a HH:mm:ss
        $horaNormalizada = Carbon::createFromFormat('H:i', $request->hora)
            ->format('H:i:s');

        $sesion->update([
            'hora' => $horaNormalizada,
            'fecha' => $request->fecha ?? $sesion->fecha,
            'modalidad' => $request->modalidad ?? $sesion->modalidad,
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
