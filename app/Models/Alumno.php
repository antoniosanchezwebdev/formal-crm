<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = "alumnos";

    protected $fillable = [
        'nombre',
        'empresa_id',
        'apellidos',
        'dni',
        'fecha_nac',
        'direccion',
        'localidad',
        'provincia',
        'cod_postal',
        'cod_winda',
        'pais',
        'telefono',
        'movil',
        'email',
        'filesPath',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
