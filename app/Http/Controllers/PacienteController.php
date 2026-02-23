<?php

namespace App\Http\Controllers;

use App\Http\Resources\PacienteCollection;
use App\Models\Paciente;
use App\Models\ProgresoActividad;
use App\Models\Sesion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->input('role') === 'psicologo') {
            $user = auth()->user();
            $psicologo = $user->psicologo;
            $totalSesionesProximas = Sesion::whereHas('paciente', function ($q) use ($psicologo) {
                $q->where('psicologo_id', $psicologo->id);
            })
                ->where('fecha', '>', now())
                ->count();

            $pacientes = $psicologo->pacientes()
                ->with([
                    'user',
                    'ultimaSesion',
                    'progresoActividad',
                ])
                ->get();

            return (new PacienteCollection($pacientes))
                ->additional([
                    'sesiones_proximas' => $totalSesionesProximas
                ]);
        }
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
    public function show(Request $request, string $id)
    {

        Carbon::setLocale('es');

        // if($request->input('role') === 'psicologo') {
            // 1. Obtener información básica del paciente y su usuario
            $paciente = Paciente::with('user')->findOrFail($id);

            // 2. Datos para el Gráfico
            $registros = DB::table('calificaciones')
                ->where('paciente_id', $id)
                ->orderBy('fecha_realizacion', 'desc') 
                ->take(7)
                ->get();

            // Luego los reordenamos cronológicamente para el gráfico (izq a der)
            $historialOrdenado = $registros->sortBy('fecha_realizacion');

            // Preparamos los arrays simples (usando values() para evitar índices extraños)
            $labels = $historialOrdenado->map(function($item) {
                // Formateamos la fecha: "10 Feb"
                return \Carbon\Carbon::parse($item->fecha_realizacion)->format('d M');
            })->values()->all();

            $valores = $historialOrdenado->pluck('calificacion_general')->values()->all();

            // 3. Estadísticas de Sesiones
            $totalSesiones = Sesion::where('paciente_id', $id)->count();
            
            $proximaSesion = Sesion::where('paciente_id', $id)
                ->where('fecha', '>=', now())
                ->orderBy('fecha', 'asc')
                ->orderBy('hora', 'asc')
                ->first();

            // 4. Módulos y Actividades (Progreso y Tabla Reciente)
            // Hacemos join con 'actividades' para obtener el nombre y descripción
            $actividades = ProgresoActividad::where('paciente_id', $id)
                ->with('actividad')
                ->orderBy('updated_at', 'desc')
                ->get();

            // Calculamos estadísticas de tareas
            $totalActividades = $actividades->count();
            $actividadesCompletadas = $actividades->where('estado', 'completado')->count();
            $porcentajeGlobal = $totalActividades > 0 
                ? round(($actividadesCompletadas / $totalActividades) * 100) 
                : 0;

            // 5. Estructurar respuesta JSON para el Frontend
            return response()->json([
                'perfil' => [
                    'id' => $paciente->id,
                    'nombre' => $paciente->user->name,
                    'email' => $paciente->user->email,
                    'nivel_estres_actual' => $paciente->nivel_estres_actual,
                    'sexo' => $paciente->sexo,
                    'edad' => $paciente->edad,
                ],
                'grafico_estres' => [
                    'labels' => $labels,
                    'data' => $valores,
                ],
                'stats' => [
                    'animo_actual' => $paciente->nivel_estres_actual > 26 ? 'Alto' : ($paciente->nivel_estres_actual > 21 ? 'Moderado' : 'Bajo'), 
                    'mejora_porcentaje' => 15, 
                    'total_sesiones' => $totalSesiones,
                    'proxima_sesion' => $proximaSesion ? $proximaSesion->fecha . ' ' . $proximaSesion->hora : null,
                    'tareas_completadas_porcentaje' => $porcentajeGlobal,
                    'total_tareas' => $totalActividades
                ],
                'modulos' => $actividades->map(function($progreso) {
                    return [
                        'id' => $progreso->id,
                        'nombre' => $progreso->actividad->nombre,
                        'progreso' => $progreso->progreso_porcentaje,
                        'estado' => $progreso->estado,
                        'fecha_actualizacion' => $progreso->updated_at->diffForHumans(),
                    ];
                }),
                'actividad_reciente' => $actividades->take(3)->map(function($progreso) {
                    return [
                        'id' => $progreso->id,
                        'nombre' => $progreso->actividad->nombre,
                        'estado' => $progreso->estado,
                        'fecha_actualizacion' => $progreso->updated_at->diffForHumans(),
                        'progreso' => $progreso->progreso_porcentaje,
                    ];
                }),
            ]);
        // }
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
