<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'id',
        'casa_id',
        'inquilino_id',
        'num_movil',
        'fecha_inicio',
        'duracion',
        'precio_total',
        'estado',
        'comprobante_pago'
    ];
}
