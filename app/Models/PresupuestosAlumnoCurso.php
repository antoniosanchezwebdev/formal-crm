<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Alumno;
use App\Models\Cursos;

class PresupuestosAlumnoCurso extends Model
{
    use HasFactory;

    protected $table = "presupuestos_alumno_curso";

    protected $fillable = [
        'presupuesto_id',
        'alumno_id',
        'curso_id',
        'precio',
        'horas'
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function alumnos(){
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }

    public function cursos(){
        return $this->belongsTo(Cursos::class, 'curso_id', 'id' );
    }

}
