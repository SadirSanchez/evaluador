<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;
    protected $table = 'respuestas';

    protected $fillable = [
        'evaluacion_id',
        'pregunta_id',
        'score',
    ];
    protected $casts = [
        'score' => 'decimal:2',
    ];
    // relación: una respuesta pertenece a una evaluacion
    public function evaluacion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }
    // relación: una respuesta pertenece a una pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id');
    }
}
