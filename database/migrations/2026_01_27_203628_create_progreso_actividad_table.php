<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('progreso_actividad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('actividad_id')->constrained('actividades')->cascadeOnDelete();
            $table->date('fecha');
            $table->float('progreso_porcentaje');
            $table->text('comentarios')->nullable();
            $table->enum('estado', ['pendiente', 'en_progreso', 'completado']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progreso_actividad');
    }
};
