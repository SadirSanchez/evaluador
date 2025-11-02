<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pregunta extends Model
{

    use HasFactory;

    protected $table = 'preguntas';

    protected $fillable = [
        'question',
        'typeAnswer',
        'unitMeasure',
        'minScore',
        'maxScore',
    ];

    protected $casts = [
        'minScore' => 'decimal:2',
        'maxScore' => 'decimal:2',
    ];

    // Relacion: una pregunta tiene muchas respuestas
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id');
    }

    public function isMetric()
    {
        return $this->typeAnswer === 'metrica';
    }
}
