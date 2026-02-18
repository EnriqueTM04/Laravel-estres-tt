<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'sexo' => ['nullable', 'string', 'in:Femenino,Masculino,Prefiero no decir,F,M,Otro'],
            'semestre' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        $data = $validator->validated();
        $sexo = $data['sexo'] ?? null;
        $sexoMap = [
            'Femenino' => 'F',
            'Masculino' => 'M',
            'Prefiero no decir' => 'Otro',
        ];
        if ($sexo !== null && array_key_exists($sexo, $sexoMap)) {
            $sexo = $sexoMap[$sexo];
        }
        if (!in_array($sexo, ['F', 'M', 'Otro'], true)) {
            $sexo = null;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'paciente',
        ]);

        Paciente::create([
            'user_id' => $user->id,
            'sexo' => $sexo,
            'semestre' => $data['semestre'] ?? null,
        ]);

        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user,
        ];
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        // Revisar password
        if (!Auth::attempt($data)) {
            return response()->json([
                'errors' => ['Las credenciales son incorrectas']
            ], 422);
        }

        // Autenticar usuario
        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}
