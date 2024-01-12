<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PresupuestosAlumnoCurso;

class Presupuestos extends Model
{
    use HasFactory;

    protected $table = "presupuestos";

    protected $fillable = [
        'numero_presupuesto',
        'empresa_id',
        'fecha_inicio',
        'fecha_fin',
        'monitor_id',
        'alumno_id',
        'curso_id',
        'detalles',
        'total_sin_iva',
        'iva',
        'descuento',
        'precio',
        'estado',
        'observaciones',
        'tiene_rangos_fecha',
        'numero_alumnos'
    ];

    /**
     * Mutaciones de fecha.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function alumnos()
    {
        return $this->hasMany(PresupuestosAlumnoCurso::class, 'presupuesto_id', 'id');
    }

    public function rangosFecha()
    {
        return $this->hasMany(RangosFecha::class, 'presupuesto_id', 'id');
    }

}
