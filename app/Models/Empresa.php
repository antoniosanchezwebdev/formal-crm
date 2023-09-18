<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresas";

    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'cif',
        'email',
        'cod_postal',
        'localidad',
        'pais',
        'persona_contacto',
        'persona_contacto_telefono',

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
