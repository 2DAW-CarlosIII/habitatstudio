<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $table = "bookings";

    protected $fillable = [
        'casa_id',
        'inquilino_id',
        'num_movil',
        'fecha_inicio',
        'duracion',
        'precio_total',
        'estado',
        'comprobante_pago'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function casa(): BelongsTo {
        return $this->belongsTo(Casa::class);
    }
}
