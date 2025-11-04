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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluacion_id')->constrained('evaluaciones')->onDelete('cascade');
            $table->foreignId('pregunta_id')->constrained('preguntas')->onDelete('restrict');
            $table->decimal('score', 5, 2); // Puntaje dado a la pregunta en esta evaluacion.
            $table->timestamps();

            // Asegurar que no haya respuestas duplicadas para la misma evaluacion y pregunta.
            $table->unique(['evaluacion_id', 'pregunta_id']);

            // Índice para consultas
            $table->index('evaluacion_id');
            $table->index('pregunta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
