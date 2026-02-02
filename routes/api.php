<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // PSS/Test endpoints protegidos (requieren autenticación)
    Route::get('/tests/{test}/preguntas', [TestController::class, 'preguntas']);
    Route::post('/tests/{test}/resultado', [TestController::class, 'resultado']);
});

// Autenticacion
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
