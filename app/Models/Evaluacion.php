<?php

namespace App\Models;

use illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'name',
        'urlPlatform',
        'evaluationDate',
        'finalGrade',
        'evaluatorName',
    ];

    protected $casts = [
        'evaluationDate' => 'date',
        'finalGrade' => 'decimal:2',
    ];

    // Relacion: una evaluacion tiene muchas respuestas
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'evaluacion_id');
    }
}
