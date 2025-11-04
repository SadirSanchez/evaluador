<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use App\Models\Pregunta;
use Illuminate\Http\Request;

class RespuestaController extends Controller
{
    /**
     * Guardar o actualizar respuesta (AJAX)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'evaluacion_id' => 'required|exists:evaluaciones,id',
            'pregunta_id' => 'required|exists:preguntas,id',
            'valueQuestion' => 'required|numeric|min:0',
        ]);

        $pregunta = Pregunta::findOrFail($validated['pregunta_id']);
        
        // Normalizar valor si es métrica
        $calificacion = $this->normalizarValor($pregunta, $validated['valueQuestion']);

        // Crear o actualizar respuesta
        $respuesta = Respuesta::updateOrCreate(
            [
                'evaluacion_id' => $validated['evaluacion_id'],
                'pregunta_id' => $validated['pregunta_id'],
            ],
            [
                'score' => $calificacion,
            ]
        );

        return response()->json([
            'success' => true,
            'score' => $calificacion,
            'message' => 'Respuesta guardada correctamente',
        ]);
    }

    /**
     * Normalizar valor de métrica a escala 0-5
     */
    private function normalizarValor($pregunta, $valor)
    {
        // Si no es métrica, el valor ya está en escala 0-5
        if (!$pregunta->isMetric()) {
            return $valor;
        }

        // Normalización según tipo de métrica
        switch ($pregunta->id) {
            case 33: // Tiempo de respuesta (ms)
                if ($valor < 500) return 5;
                if ($valor < 1000) return 4;
                if ($valor < 2000) return 3;
                if ($valor < 3000) return 2;
                if ($valor < 5000) return 1;
                return 0;

            case 34: // Disponibilidad (%)
                if ($valor >= 99.9) return 5;
                if ($valor >= 99.0) return 4;
                if ($valor >= 98.0) return 3;
                if ($valor >= 95.0) return 2;
                if ($valor >= 90.0) return 1;
                return 0;

            case 35: // Funcionalidades implementadas (%)
                if ($valor >= 95) return 5;
                if ($valor >= 85) return 4;
                if ($valor >= 70) return 3;
                if ($valor >= 50) return 2;
                if ($valor >= 30) return 1;
                return 0;

            case 36: // Tasa de errores (errores/100 ops)
                if ($valor <= 1) return 5;
                if ($valor <= 3) return 4;
                if ($valor <= 5) return 3;
                if ($valor <= 10) return 2;
                if ($valor <= 20) return 1;
                return 0;

            case 37: // Tiempo tarea (min)
                if ($valor <= 3) return 5;
                if ($valor <= 5) return 4;
                if ($valor <= 10) return 3;
                if ($valor <= 15) return 2;
                if ($valor <= 30) return 1;
                return 0;

            case 38: // Tareas exitosas (%)
                if ($valor >= 95) return 5;
                if ($valor >= 85) return 4;
                if ($valor >= 70) return 3;
                if ($valor >= 50) return 2;
                if ($valor >= 30) return 1;
                return 0;

            case 39: // Fallos críticos
                if ($valor == 0) return 5;
                if ($valor <= 2) return 4;
                if ($valor <= 5) return 3;
                if ($valor <= 10) return 2;
                if ($valor <= 20) return 1;
                return 0;

            case 40: // Tiempo recuperación (min)
                if ($valor <= 5) return 5;
                if ($valor <= 15) return 4;
                if ($valor <= 30) return 3;
                if ($valor <= 60) return 2;
                if ($valor <= 120) return 1;
                return 0;

            default:
                return 0;
        }
    }
}