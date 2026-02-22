<?php

namespace App\Http\Controllers;

use App\Http\Resources\PsicologoCollection;
use App\Models\Psicologo;
use Illuminate\Http\Request;

class PsicologoController extends Controller
{
    /**
     * Public listing for mobile app (name only).
     */
    public function publicIndex()
    {
        $psicologos = Psicologo::with('user')->get();

        return response()->json([
            'data' => $psicologos->map(function ($psicologo) {
                return [
                    'id' => $psicologo->id,
                    'name' => $psicologo->user?->name,
                ];
            })->values(),
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (!$request->input('role') === 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $psicologos = Psicologo::with('user')->get();

        return (new PsicologoCollection($psicologos));
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
