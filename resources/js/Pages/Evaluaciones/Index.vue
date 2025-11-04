<template>
    <AppLayout title="Evaluador de Calidad">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 mb-6"
                >
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">
                        Evaluador de Calidad de Software Educativo
                    </h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Sistema de evaluación basado en normas ISO/IEC 25010 e
                        ISO/IEC 25023
                    </p>

                    <Link
                        :href="route('evaluaciones.create')"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition duration-150 ease-in-out"
                    >
                        <svg
                            class="w-5 h-5 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        Nueva Evaluación
                    </Link>
                </div>

                <!-- 🎥 VIDEO EXPLICATIVO IMPORTANCIA DE LA CALIDAD DEL SOFTWARE -->
                <div
                    v-if="mostrarVideo"
                    class="bg-gradient-to-br from-purple-600 to-blue-600 shadow-2xl sm:rounded-lg p-8 mb-6 relative"
                >
                    <!-- Botón cerrar -->
                    <button
                        @click="mostrarVideo = false"
                        class="absolute top-4 right-4 text-white hover:text-gray-200 transition"
                    >
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                    <div class="text-center mb-6">
                        <div class="flex items-center justify-center mb-4">
                            <svg
                                class="w-12 h-12 text-white mr-3"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"
                                />
                            </svg>
                            <h2 class="text-3xl font-bold text-white">
                                Importancia de la calidad de software
                            </h2>
                        </div>
                        <p class="text-white text-lg opacity-90">
                            En este video se detalla la importancia de la calidad del software
                        </p>
                    </div>

                    <!-- Video de YouTube explicativo importancia de la calidad -->
                    <div
                        class="relative"
                        style="padding-bottom: 56.25%; height: 0"
                    >
                        <iframe
                            class="absolute top-0 left-0 w-full h-full rounded-lg shadow-2xl"
                            src="https://www.youtube.com/embed/tUeny-MDz_Q?rel=0&modestbranding=1"
                            title="Tutorial del Sistema Evaluador"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-white text-sm opacity-75">
                            💡 Puedes cerrar este video en cualquier momento
                            haciendo clic en la X
                        </p>
                    </div>
                </div>

                <!-- Botón para volver a mostrar video si lo cerró -->
                <button
                    v-if="!mostrarVideo"
                    @click="mostrarVideo = true"
                    class="w-full bg-purple-50 border-2 border-purple-200 hover:bg-purple-100 rounded-lg p-4 mb-6 transition flex items-center justify-center"
                >
                    <svg
                        class="w-6 h-6 text-purple-600 mr-2"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"
                        />
                    </svg>
                    <span class="text-purple-800 font-semibold">
                        📹 Ver video tutorial nuevamente
                    </span>
                </button>

                <!-- Información de Normas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ISO 25010 -->
                    <div
                        class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                    >
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
                            >
                                <svg
                                    class="w-6 h-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">
                                ISO/IEC 25010
                            </h2>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Calidad del Producto Software
                        </p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li>✓ Adecuación Funcional</li>
                            <li>✓ Eficiencia de Desempeño</li>
                            <li>✓ Compatibilidad</li>
                            <li>✓ Usabilidad</li>
                            <li>✓ Fiabilidad</li>
                            <li>✓ Seguridad</li>
                            <li>✓ Mantenibilidad</li>
                            <li>✓ Portabilidad</li>
                        </ul>
                        <div class="mt-4 text-sm font-semibold text-blue-600">
                            32 preguntas • Peso: 80%
                        </div>
                    </div>

                    <!-- ISO 25023 -->
                    <div
                        class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"
                    >
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4"
                            >
                                <svg
                                    class="w-6 h-6 text-green-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">
                                ISO/IEC 25023
                            </h2>
                        </div>
                        <p class="text-gray-600 mb-4">Medición de la Calidad</p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li>✓ Tiempo de respuesta</li>
                            <li>✓ Disponibilidad del sistema</li>
                            <li>✓ Funcionalidades implementadas</li>
                            <li>✓ Tasa de errores</li>
                            <li>✓ Tiempo de tareas</li>
                            <li>✓ Tareas exitosas</li>
                            <li>✓ Fallos críticos</li>
                            <li>✓ Tiempo de recuperación</li>
                        </ul>
                        <div class="mt-4 text-sm font-semibold text-green-600">
                            8 métricas • Peso: 20%
                        </div>
                    </div>
                </div>

                <!-- Instrucciones -->
                <div
                    class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6"
                >
                    <h3 class="text-lg font-semibold text-blue-800 mb-3">
                        📋 Cómo usar el evaluador
                    </h3>
                    <ol
                        class="list-decimal list-inside space-y-2 text-blue-900"
                    >
                        <li>Haz clic en "Nueva Evaluación" para comenzar</li>
                        <li>
                            Ingresa los datos básicos del software a evaluar
                        </li>
                        <li>
                            Responde las 40 preguntas del checklist (escala 0-5)
                        </li>
                        <li>
                            El sistema calculará automáticamente la calificación
                            final
                        </li>
                        <li>Visualiza los resultados y análisis detallado</li>
                    </ol>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const mostrarVideo = ref(true);

</script>
