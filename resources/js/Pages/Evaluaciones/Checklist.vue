<template>
    <AppLayout title="Checklist de Evaluación">
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div
                    class="bg-white shadow-xl sm:rounded-lg p-6 mb-6 sticky top-0 z-10"
                >
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">
                                {{ evaluacion.name }}
                            </h1>
                            <p class="text-sm text-gray-600">
                                Evaluador: {{ evaluacion.evaluatorName }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN ISO 25010 -->
                <div class="bg-white shadow-xl sm:rounded-lg p-6 mb-6">
                    <div class="mb-6 pb-4 border-b">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">
                            ISO/IEC 25010 - Calidad del Producto
                        </h2>
                        <p class="text-gray-600">32 preguntas • Peso: 80%</p>
                    </div>

                    <!-- Por cada característica -->
                    <div
                        v-for="(caracteristica, idx) in caracteristicas"
                        :key="idx"
                        class="mb-8"
                    >
                        <h3
                            class="text-xl font-semibold text-gray-700 mb-4 flex items-center"
                        >
                            <span
                                class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3 text-sm font-bold"
                            >
                                {{ idx + 1 }}
                            </span>
                            {{ caracteristica.nombre }}
                        </h3>

                        <!-- Preguntas de la característica -->
                        <div class="space-y-6 ml-11">
                            <div
                                v-for="pregunta in seccionISO25010.slice(
                                    caracteristica.inicio,
                                    caracteristica.fin
                                )"
                                :key="pregunta.id"
                                class="p-4 bg-gray-50 rounded-lg"
                            >
                                <p class="font-medium text-gray-800 mb-3">
                                    {{ pregunta.id }}. {{ pregunta.question }}
                                </p>

                                <!-- Escala 0-5 -->
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-600 mr-2"
                                        >Escala:</span
                                    >
                                    <button
                                        v-for="valueQuestion in [
                                            0, 1, 2, 3, 4, 5,
                                        ]"
                                        :key="valueQuestion"
                                        @click="
                                            seleccionarValor(
                                                pregunta.id,
                                                valueQuestion
                                            )
                                        "
                                        :disabled="guardando[pregunta.id]"
                                        class="w-12 h-12 rounded-lg font-semibold transition-all"
                                        :class="[
                                            respuestas[pregunta.id] ===
                                            valueQuestion
                                                ? 'bg-blue-600 text-white shadow-lg scale-110'
                                                : 'bg-white text-gray-700 hover:bg-blue-50 border-2 border-gray-300',
                                        ]"
                                    >
                                        {{ valueQuestion }}
                                    </button>

                                    <span
                                        v-if="guardando[pregunta.id]"
                                        class="ml-3 text-sm text-gray-500"
                                    >
                                        Guardando...
                                    </span>
                                    <span
                                        v-else-if="
                                            respuestas[pregunta.id] !==
                                            undefined
                                        "
                                        class="ml-3 text-sm text-green-600"
                                    >
                                        ✓ Guardado
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN ISO 25023 -->
                <div class="bg-white shadow-xl sm:rounded-lg p-6 mb-6">
                    <div class="mb-6 pb-4 border-b">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">
                            ISO/IEC 25023 - Métricas de Calidad
                        </h2>
                        <p class="text-gray-600">
                            8 métricas cuantitativas • Peso: 20%
                        </p>
                    </div>

                    <div class="space-y-6">
                        <div
                            v-for="pregunta in seccionISO25023"
                            :key="pregunta.id"
                            class="p-4 bg-green-50 rounded-lg"
                        >
                            <p class="font-medium text-gray-800 mb-3">
                                {{ pregunta.id }}. {{ pregunta.question }}
                            </p>

                            <!-- Input para métrica -->
                            <div class="flex items-center gap-4">
                                <input
                                    type="number"
                                    :min="pregunta.minScore"
                                    :max="pregunta.maxScore"
                                    step="0.01"
                                    :value="respuestas[pregunta.id]"
                                    @change="
                                        seleccionarValor(
                                            pregunta.id,
                                            $event.target.value
                                        )
                                    "
                                    :disabled="guardando[pregunta.id]"
                                    class="w-32 px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    :placeholder="`0 - ${pregunta.maxScore}`"
                                />
                                <span
                                    class="text-sm font-semibold text-gray-700"
                                >
                                    {{ pregunta.unitMeasure }}
                                </span>

                                <span
                                    v-if="guardando[pregunta.id]"
                                    class="ml-3 text-sm text-gray-500"
                                >
                                    Guardando...
                                </span>
                                <span
                                    v-else-if="
                                        respuestas[pregunta.id] !== undefined
                                    "
                                    class="ml-3 text-sm text-green-600"
                                >
                                    ✓ Guardado
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón Calcular -->
                <div class="bg-white shadow-xl sm:rounded-lg p-6 text-center">
                    <button
                        @click="calcularCalificacion"
                        :disabled="progreso < 40 || calculando"
                        class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white text-lg font-bold rounded-lg shadow-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span v-if="calculando">Calculando...</span>
                        <span v-else-if="progreso < 40">
                            Completa las {{ 40 - progreso }} preguntas restantes
                        </span>
                        <span v-else> ✓ Calcular Calificación Final </span>
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    evaluacion: Object,
    preguntas: Array,
    respuestasExistentes: Object,
});

// Estado de respuestas
const respuestas = ref({ ...props.respuestasExistentes });
const guardando = ref({});
const calculando = ref(false);

// Guardar respuesta (autoguardado)
const guardarRespuesta = async (preguntaId, valueQuestion) => {
    guardando.value[preguntaId] = true;

    try {
        const response = await axios.post(route("respuestas.store"), {
            evaluacion_id: props.evaluacion.id,
            pregunta_id: preguntaId,
            valueQuestion: valueQuestion,
        });

        if (response.data.success) {
            respuestas.value[preguntaId] = response.data.score;
        }
    } catch (error) {
        console.error("Error al guardar:", error);
        alert("Error al guardar la respuesta. Intenta nuevamente.");
    } finally {
        guardando.value[preguntaId] = false;
    }
};

// Seleccionar valor
const seleccionarValor = (preguntaId, valueQuestion) => {
    respuestas.value[preguntaId] = valueQuestion;
    guardarRespuesta(preguntaId, valueQuestion);
};

// Calcular calificación
const calcularCalificacion = () => {
    calculando.value = true;
    router.post(route("evaluaciones.calcular", props.evaluacion.id));
};

// Agrupar preguntas por sección
const seccionISO25010 = computed(() => props.preguntas.slice(0, 32));
const seccionISO25023 = computed(() => props.preguntas.slice(32, 40));

// Características ISO 25010
const caracteristicas = [
    { nombre: "Adecuación Funcional", inicio: 0, fin: 4 },
    { nombre: "Eficiencia de Desempeño", inicio: 4, fin: 8 },
    { nombre: "Compatibilidad", inicio: 8, fin: 12 },
    { nombre: "Usabilidad", inicio: 12, fin: 16 },
    { nombre: "Fiabilidad", inicio: 16, fin: 20 },
    { nombre: "Seguridad", inicio: 20, fin: 24 },
    { nombre: "Mantenibilidad", inicio: 24, fin: 28 },
    { nombre: "Portabilidad", inicio: 28, fin: 32 },
];
</script>
