<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\RespuestaController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('evaluaciones.index');
    })->middleware(['auth', 'verified'])->name('dashboard');
});

Route::middleware(['auth:sanctum'])->group(function () {

    //Página principal de evaluaciones
    Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');

    //Crear nueva evaluación
    Route::get('/evaluaciones/create', [EvaluacionController::class, 'create'])->name('evaluaciones.create');
    Route::post('/evaluaciones', [EvaluacionController::class, 'store'])->name('evaluaciones.store');

    //Checklist de preguntas para una evaluación
    Route::get('/evaluaciones/{id}/checklist', [EvaluacionController::class, 'checklist'])->name('evaluaciones.checklist');

    //Guardar respuestas (AJAX)
    Route::post('/respuestas', [RespuestaController::class, 'store'])->name('respuestas.store');

    // Calcular calificaciones
    Route::post('/evaluaciones/{id}/calcular', [EvaluacionController::class, 'calcular'])->name('evaluaciones.calcular');

    // Ver resultados de una evaluación
    Route::get('/evaluaciones/{id}/resultados', [EvaluacionController::class, 'resultados'])->name('evaluaciones.resultados');
});
