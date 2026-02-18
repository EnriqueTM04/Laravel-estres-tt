<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProgresoActividadController;
use App\Http\Controllers\PsicologoController;
use App\Http\Controllers\RespuestaTestController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/pacientes', PacienteController::class);
    Route::apiResource('/psicologos', PsicologoController::class);
    Route::apiResource('/sesiones', SesionController::class)->parameters(['sesiones' => 'sesion']);
    Route::apiResource('/tests', RespuestaTestController::class);
    Route::apiResource('/actividades', ActividadController::class);
    Route::post('/respuestas-test', [RespuestaTestController::class]);
    Route::post('/progreso-actividad', [ProgresoActividadController::class]);

    // PSS/Test endpoints protegidos (requieren autenticación)
    Route::get('/tests/{test}/preguntas', [TestController::class, 'preguntas']);
    Route::post('/tests/{test}/resultado', [TestController::class, 'resultado']);

    // Historial de estrés del paciente autenticado
    Route::get('/pacientes/me/estres-registros', [PacienteController::class, 'estresRegistros']);
});

// Autenticacion
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
