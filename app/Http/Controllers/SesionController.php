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
