<template>
    <AppLayout title="Resultados de Evaluación">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="bg-white shadow-xl sm:rounded-lg p-8 mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        Resultados de Evaluación
                    </h1>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl text-gray-700 font-semibold">
                                {{ evaluacion.name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Evaluado por {{ evaluacion.evaluatorName }} el
                                {{
                                    new Date(
                                        evaluacion.evaluationDate
                                    ).toLocaleDateString("es-ES")
                                }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">
                                Normas aplicadas:
                            </p>
                            <p class="text-xs text-gray-500">
                                ISO/IEC 25010:2011 • ISO/IEC 25023:2016
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Calificación Final Destacada -->
                <div
                    class="bg-gradient-to-br from-blue-600 to-blue-800 shadow-2xl sm:rounded-lg p-12 mb-6 text-center text-white"
                >
                    <p class="text-2xl font-semibold mb-4 opacity-90">
                        CALIFICACIÓN FINAL
                    </p>

                    <div class="text-8xl font-bold mb-4">
                        {{ evaluacion.finalGrade }}
                        <span class="text-4xl opacity-75">/ 5.00</span>
                    </div>

                    <!-- Barra de progreso visual -->
                    <div class="max-w-md mx-auto mb-6">
                        <div
                            class="w-full bg-blue-900 bg-opacity-30 rounded-full h-6"
                        >
                            <div
                                class="bg-white h-6 rounded-full transition-all duration-1000"
                                :style="`width: ${
                                    (evaluacion.finalGrade / 5) * 100
                                }%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <!-- Desglose por Normas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- ISO 25010 -->
                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">
                                    ISO/IEC 25010
                                </h2>
                                <p class="text-sm text-gray-600">
                                    Calidad del Producto • Peso: 80%
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl font-bold text-blue-600">
                                    {{ desglose.iso25010 }}
                                </div>
                                <div class="text-sm text-gray-500">/ 5.00</div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div
                                :class="getColorClass(desglose.iso25010)"
                                class="h-4 rounded-full transition-all duration-1000"
                                :style="`width: ${
                                    (desglose.iso25010 / 5) * 100
                                }%`"
                            ></div>
                        </div>
                    </div>

                    <!-- ISO 25023 -->
                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">
                                    ISO/IEC 25023
                                </h2>
                                <p class="text-sm text-gray-600">
                                    Métricas de Calidad • Peso: 20%
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-4xl font-bold text-green-600">
                                    {{ desglose.iso25023 }}
                                </div>
                                <div class="text-sm text-gray-500">/ 5.00</div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div
                                :class="getColorClass(desglose.iso25023)"
                                class="h-4 rounded-full transition-all duration-1000"
                                :style="`width: ${
                                    (desglose.iso25023 / 5) * 100
                                }%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-blue-800 mb-3">
                        Interpretación Final
                    </h2>
                    <p class="text-blue-900 leading-relaxed mb-4">
                        El software
                        <strong>{{ evaluacion.name }}</strong>
                        obtuvo una calificación de
                        <strong>{{ evaluacion.finalGrade }}/5.00</strong>,
                        clasificándose como
                        <strong>"{{ nivelCalidad.texto }}"</strong> según los
                        estándares de calidad ISO/IEC 25010 e ISO/IEC 25023.
                    </p>
                </div>

                <!-- Acciones -->
                <div class="flex justify-center gap-4">
                    <a
                        :href="route('evaluaciones.index')"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition"
                    >
                        🏠 Volver al Inicio
                    </a>

                    <a
                        :href="route('evaluaciones.create')"
                        class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition"
                    >
                        ➕ Nueva Evaluación
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { computed } from "vue";

const props = defineProps({
    evaluacion: Object,
    desglose: Object,
});

// Determinar nivel de calidad
const nivelCalidad = computed(() => {
    const calif = props.evaluacion.finalGrade;
    if (calif >= 4.5)
        return {
            texto: "Excelente",
            color: "text-green-700",
            bg: "bg-green-100",
        };
    if (calif >= 4.0)
        return {
            texto: "Muy Bueno",
            color: "text-green-600",
            bg: "bg-green-50",
        };
    if (calif >= 3.0)
        return { texto: "Bueno", color: "text-yellow-600", bg: "bg-yellow-50" };
    if (calif >= 2.0)
        return {
            texto: "Regular",
            color: "text-orange-600",
            bg: "bg-orange-50",
        };
    return { texto: "Deficiente", color: "text-red-600", bg: "bg-red-50" };
});

// Obtener color por calificación
const getColorClass = (calificacion) => {
    if (calificacion >= 4.5) return "bg-green-500";
    if (calificacion >= 4.0) return "bg-green-400";
    if (calificacion >= 3.0) return "bg-yellow-400";
    if (calificacion >= 2.0) return "bg-orange-400";
    return "bg-red-400";
};
</script>
