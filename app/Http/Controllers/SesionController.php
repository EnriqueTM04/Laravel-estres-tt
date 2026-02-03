<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $psicologo = $user->psicologo;

        if (
            $request->query('role') === 'psicologo' &&
            $request->query('consulta') === 'ultimos'
        ) {
            $pacientes = $psicologo->pacientes()
                ->with([
                    'sesiones' => function ($q) {
                        $q->latest('fecha')->limit(1);
                    }
                ])
                ->withCount([
                    'sesiones as sesiones_proximas' => function ($q) {
                        $q->where('fecha', '>', now());
                    }
                ])
                ->get();

            return response()->json($pacientes);
        }

        return response()->json([]);
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
