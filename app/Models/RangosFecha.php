<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangosFecha extends Model
{
    use HasFactory;

    protected $table = "presupuesto_rangos_fecha";

    protected $fillable = [
        'presupuesto_id',
        'fecha_1',
        'fecha_2',
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
