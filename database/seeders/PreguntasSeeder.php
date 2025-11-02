<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pregunta;

class PreguntasSeeder extends Seeder
{
    public function run(): void
    {
        $preguntas = [
            // ISO 25010 - Adecuación Funcional (4 preguntas)
            [
                'question' => '¿El software proporciona todas las funciones necesarias para la enseñanza/aprendizaje?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Las funciones implementadas producen resultados correctos y precisos?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Las funcionalidades son apropiadas para los objetivos educativos?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿El software facilita el logro de metas de aprendizaje?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25010 - Eficiencia de Desempeño (4 preguntas)
            [
                'question' => '¿Los tiempos de respuesta son adecuados para la interacción educativa?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿El software hace un uso eficiente de los recursos (CPU, memoria, ancho de banda)?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿El sistema soporta la cantidad esperada de usuarios concurrentes?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿El rendimiento es consistente bajo diferentes cargas de trabajo?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25010 - Compatibilidad (4 preguntas)
            [
                'question' => '¿El software coexiste con otros sistemas educativos sin problemas?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Se integra fácilmente con otras herramientas educativas?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Intercambia información correctamente con otros sistemas?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Es compatible con diferentes navegadores y dispositivos?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25010 - Usabilidad (4 preguntas)
            [
                'question' => '¿La interfaz es intuitiva y fácil de entender?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Es fácil aprender a usar el software?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Las operaciones son fáciles de realizar?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿La interfaz es estéticamente agradable y atractiva?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25010 - Fiabilidad (4 preguntas)
            [
                'question' => '¿El sistema presenta bajo nivel de fallos durante su uso?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿El software está disponible cuando se necesita?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿El sistema continúa funcionando ante fallos menores?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Puede recuperar datos tras una falla?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25010 - Seguridad (4 preguntas)
            [
                'question' => '¿Protege adecuadamente la información de estudiantes y profesores?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Previene accesos no autorizados?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Implementa autenticación robusta de usuarios?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Garantiza la integridad de los datos educativos?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25010 - Mantenibilidad (4 preguntas)
            [
                'question' => '¿El sistema está organizado en módulos bien definidos?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Es fácil identificar y diagnosticar problemas?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Se pueden realizar modificaciones sin afectar otras funcionalidades?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿El sistema permite actualizaciones sin interrupciones?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25010 - Portabilidad (4 preguntas)
            [
                'question' => '¿Se adapta a diferentes entornos tecnológicos?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Es fácil de instalar y configurar?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Funciona correctamente en diferentes sistemas operativos?',
                'typeAnswer' => 'escala_0_5',
            ],
            [
                'question' => '¿Puede usarse en dispositivos móviles y tablets?',
                'typeAnswer' => 'escala_0_5',
            ],

            // ISO 25023 - Métricas (8 preguntas)
            [
                'question' => 'Tiempo de respuesta promedio (milisegundos)',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => 'ms',
                'minScore' => 0,
                'maxScore' => 10000,
            ],
            [
                'question' => 'Porcentaje de disponibilidad del sistema',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => '%',
                'minScore' => 0,
                'maxScore' => 100,
            ],
            [
                'question' => 'Porcentaje de funcionalidades implementadas',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => '%',
                'minScore' => 0,
                'maxScore' => 100,
            ],
            [
                'question' => 'Tasa de errores (errores por 100 operaciones)',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => 'errores',
                'minScore' => 0,
                'maxScore' => 100,
            ],
            [
                'question' => 'Tiempo promedio para completar tarea común (minutos)',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => 'min',
                'minScore' => 0,
                'maxScore' => 60,
            ],
            [
                'question' => 'Porcentaje de tareas completadas exitosamente',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => '%',
                'minScore' => 0,
                'maxScore' => 100,
            ],
            [
                'question' => 'Número de fallos críticos en el último mes',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => 'fallos',
                'minScore' => 0,
                'maxScore' => 100,
            ],
            [
                'question' => 'Tiempo promedio de recuperación ante fallos (minutos)',
                'typeAnswer' => 'metrica_numerica',
                'unitMeasure' => 'min',
                'minScore' => 0,
                'maxScore' => 120,
            ],
        ];

        foreach ($preguntas as $pregunta) {
            Pregunta::create($pregunta);
        }
    }
}
