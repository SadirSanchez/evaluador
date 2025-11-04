<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluacionController extends Controller
{
    /**
     * Mostrar página de inicio
     */
    public function index()
    {
        return Inertia::render('Evaluaciones/Index');
    }

    // Mostrar formulario de creación
    public function create()
    {
        return Inertia::render('Evaluaciones/Create');
    }

    // Guardar nueva evaluación

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'urlPlatform' => 'nullable|url|max:255',
                'evaluationDate' => 'required|date|before_or_equal:today',
                'evaluatorName' => 'required|string|max:255',
            ],
            [
                'name.required' => 'El nombre de la evaluación es obligatorio.',
                'urlPlatform.url' => 'La URL de la plataforma debe ser una URL válida.',
                'evaluationDate.required' => 'La fecha de la evaluación es obligatoria.',
                'evaluationDate.before_or_equal' => 'La fecha de la evaluación no puede ser futura',
                'evaluatorName.required' => 'El nombre del evaluador es obligatorio.',


            ]
        );

        // Crear la evaluacion
        $evaluacion = Evaluacion::create($validated);
        return redirect()->route('evaluaciones.checklist', $evaluacion->id);
    }

    /**
     * Mostrar checklist de preguntas
     */
    public function checklist($id)
    {
        $evaluacion = Evaluacion::findOrFail($id);

        // Obtener las preguntas ordenadas
        $preguntas = Pregunta::orderBy('id')->get();

        // Obtener respuestas existentes (si está retomando)
        $respuestas = Respuesta::where('evaluacion_id', $id)
            ->pluck('score', 'pregunta_id')
            ->toArray();

        return Inertia::render('Evaluaciones/Checklist', [
            'evaluacion' => $evaluacion,
            'preguntas' => $preguntas,
            'respuestasExistentes' => $respuestas,
        ]);
    }

/**
     * Calcular calificación final
     */
    public function calcular($id)
    {
        $evaluacion = Evaluacion::with('respuestas')->findOrFail($id);
        
        // Verificar que estén las 40 respuestas
        if ($evaluacion->respuestas->count() !== 40) {
            return back()->with('error', 'Debe completar las 40 preguntas antes de calcular.');
        }

        // Calcular calificación
        $calificacion = $this->calcularCalificacionFinal($evaluacion);
        
        // Guardar calificación
        $evaluacion->update([
            'finalGrade' => $calificacion
        ]);

        // Redirigir a resultados
        return redirect()->route('evaluaciones.resultados', $evaluacion->id);
    }

    /**
     * Mostrar resultados de la evaluación
     */
    public function resultados($id)
    {
        $evaluacion = Evaluacion::with('respuestas.pregunta')->findOrFail($id);
        
        // Verificar que tenga calificación
        if (!$evaluacion->finalGrade) {
            return redirect()->route('evaluaciones.checklist', $id)
                ->with('error', 'Debe calcular la calificación primero.');
        }

        // Calcular desglose por características
        $desglose = $this->calcularDesglose($evaluacion);

        return Inertia::render('Evaluaciones/Resultados', [
            'evaluacion' => $evaluacion,
            'desglose' => $desglose,
        ]);
    }

    /**
     * Método privado: Calcular calificación final
     */
    private function calcularCalificacionFinal($evaluacion)
    {
        // Obtener las 40 respuestas
        $respuestas = $evaluacion->respuestas;

        // Separar ISO 25010 (primeras 32) e ISO 25023 (últimas 8)
        $respuestasISO25010 = $respuestas->filter(function($r) {
            return $r->pregunta->id <= 32;
        });

        $respuestasISO25023 = $respuestas->filter(function($r) {
            return $r->pregunta->id > 32;
        });

        // Calcular promedio ISO 25010
        $promedioISO25010 = $respuestasISO25010->avg('score');

        // Calcular promedio ISO 25023
        $promedioISO25023 = $respuestasISO25023->avg('score');

        // Calcular calificación final ponderada (80% ISO25010, 20% ISO25023)
        $calificacionFinal = ($promedioISO25010 * 0.80) + ($promedioISO25023 * 0.20);

        return round($calificacionFinal, 2);
    }

    /**
     * Método privado: Calcular desglose por características
     */
    private function calcularDesglose($evaluacion)
    {
        $caracteristicas = [
            ['nombre' => 'Adecuación Funcional', 'inicio' => 1, 'fin' => 4],
            ['nombre' => 'Eficiencia de Desempeño', 'inicio' => 5, 'fin' => 8],
            ['nombre' => 'Compatibilidad', 'inicio' => 9, 'fin' => 12],
            ['nombre' => 'Usabilidad', 'inicio' => 13, 'fin' => 16],
            ['nombre' => 'Fiabilidad', 'inicio' => 17, 'fin' => 20],
            ['nombre' => 'Seguridad', 'inicio' => 21, 'fin' => 24],
            ['nombre' => 'Mantenibilidad', 'inicio' => 25, 'fin' => 28],
            ['nombre' => 'Portabilidad', 'inicio' => 29, 'fin' => 32],
        ];

        $desglose = [];

        foreach ($caracteristicas as $caracteristica) {
            $respuestas = $evaluacion->respuestas->filter(function($r) use ($caracteristica) {
                $orden = $r->pregunta->id;
                return $orden >= $caracteristica['inicio'] && $orden <= $caracteristica['fin'];
            });

            $promedio = $respuestas->avg('score');

            $desglose[] = [
                'nombre' => $caracteristica['nombre'],
                'score' => round($promedio, 2),
            ];
        }

        // Agregar promedios de normas
        $promedioISO25010 = collect($desglose)->avg('score');
        
        $respuestasISO25023 = $evaluacion->respuestas->filter(function($r) {
            return $r->pregunta->id > 32;
        });
        $promedioISO25023 = $respuestasISO25023->avg('score');

        return [
            'caracteristicas' => $desglose,
            'iso25010' => round($promedioISO25010, 2),
            'iso25023' => round($promedioISO25023, 2),
        ];
    }
}