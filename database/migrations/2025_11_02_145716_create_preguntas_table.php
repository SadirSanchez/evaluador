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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->string('typeAnswer'); // 'escala 0 - 5' o 'metrica'.
            $table->string('unitMeasure')->nullable(); // Unidad de medida %, 'ms', etc.
            $table->decimal('minScore', 10, 2)->nullable(); // Puntaje maximo de la pregunta.
            $table->decimal('maxScore', 10, 2)->nullable(); // Puntaje maximo de la pregunta.
            $table->timestamps();

            // Índice para búsquedas rápidas por tipo de respuesta.
            $table->index('typeAnswer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
