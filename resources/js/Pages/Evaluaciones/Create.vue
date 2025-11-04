<template>
    <AppLayout title="Nueva Evaluación">
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8"
                >
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">
                            Nueva Evaluación
                        </h1>
                        <p class="text-gray-600">
                            Ingresa los datos básicos del software educativo a
                            evaluar
                        </p>
                    </div>

                    <!-- Formulario -->
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Nombre de la Plataforma -->
                        <div>
                            <label
                                for="name"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Nombre del Software
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="Ejemplo: Moodle, Google Classroom, Coursera"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{ 'border-red-500': form.errors.name }"
                            />
                            <p
                                v-if="form.errors.name"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- URL -->
                        <div>
                            <label
                                for="urlPlatform"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                URL del Software
                                <span class="text-gray-400">(Opcional)</span>
                            </label>
                            <input
                                id="urlPlatform"
                                v-model="form.urlPlatform"
                                type="url"
                                placeholder="https://ejemplo.com"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{
                                    'border-red-500': form.errors.urlPlatform,
                                }"
                            />
                            <p
                                v-if="form.errors.urlPlatform"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.urlPlatform }}
                            </p>
                        </div>

                        <!-- Fecha de Evaluación -->
                        <div>
                            <label
                                for="evaluationDate"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Fecha de Evaluación
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="evaluationDate"
                                v-model="form.evaluationDate"
                                type="date"
                                required
                                :max="new Date().toISOString().split('T')[0]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{
                                    'border-red-500':
                                        form.errors.evaluationDate,
                                }"
                            />
                            <p
                                v-if="form.errors.evaluationDate"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.evaluationDate }}
                            </p>
                        </div>

                        <!-- evaluatorName -->
                        <div>
                            <label
                                for="evaluatorName"
                                class="block text-sm font-semibold text-gray-700 mb-2"
                            >
                                Nombre del evaluador
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="evaluatorName"
                                v-model="form.evaluatorName"
                                type="text"
                                required
                                placeholder="Tu nombre completo"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                :class="{
                                    'border-red-500': form.errors.evaluatorName,
                                }"
                            />
                            <p
                                v-if="form.errors.evaluatorName"
                                class="mt-1 text-sm text-red-600"
                            >
                                {{ form.errors.evaluatorName }}
                            </p>
                        </div>

                        <!-- Botones -->
                        <div
                            class="flex items-center justify-between pt-6 border-t"
                        >
                            <a
                                :href="route('evaluaciones.index')"
                                class="px-6 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-semibold transition"
                            >
                                Cancelar
                            </a>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition duration-150 ease-in-out disabled:opacity-50"
                            >
                                <span v-if="form.processing">Guardando...</span>
                                <span v-else>Iniciar Evaluación →</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
    name: "",
    urlPlatform: "",
    evaluationDate: new Date().toISOString().split("T")[0],
    evaluatorName: "",
});

const submit = () => {
    form.post(route("evaluaciones.store"), {
        preserveScroll: true,
    });
};
</script>
