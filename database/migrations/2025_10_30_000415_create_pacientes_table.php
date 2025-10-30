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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('psicologo_id')->nullable()->constrained('psicologos')->cascadeOnDelete();
            $table->tinyInteger('edad')->unsigned()->nullable();
            $table->enum('sexo', ['M', 'F', 'Otro'])->nullable();
            $table->float('nivel_estres_actual')->default(0);
            $table->tinyInteger('semestre')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
