<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request) {

    }

    public function login(LoginRequest $request) {
        $data = $request->validated();

        // Revisar password
        if(!Auth::attempt($data)) {
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

    public function logout(Request $request) {

    }
}
