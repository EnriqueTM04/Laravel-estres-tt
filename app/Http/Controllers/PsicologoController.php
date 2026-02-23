<?php

namespace App\Http\Controllers;

use App\Http\Resources\PsicologoCollection;
use App\Models\Psicologo;
use App\Models\User;
use Illuminate\Http\Request;

class PsicologoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if(!$request->input('role') === 'admin') {
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
        if(!$request->input('role') === 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',            
                'regex:/[a-z]/',     
                'regex:/[A-Z]/',   
                'regex:/[0-9]/',    
                'regex:/[@$!%*?&.]/',
            ],
        ]);

        $psicologo = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'psicologo',
        ]);

        Psicologo::create([
            'user_id' => $psicologo->id,
            'cedula_profesional' => ''
        ]);

        return response()->json(['message' => 'Psicólogo creado exitosamente']);
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
        if(!$request->input('role') === 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $psicologo = Psicologo::findOrFail($id);
        $user = $psicologo->user;

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                'string',
                'min:8',            
                'regex:/[a-z]/',     
                'regex:/[A-Z]/',   
                'regex:/[0-9]/',    
                'regex:/[@$!%*?&.]/',
            ],
        ]);

        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        if (isset($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        return response()->json(['message' => 'Psicólogo actualizado exitosamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $psicologo = Psicologo::findOrFail($id);
        $user = $psicologo->user;

        $user->delete();
        $psicologo->delete();

        return response()->json(['message' => 'Psicólogo eliminado exitosamente']);
    }
}
