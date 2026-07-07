<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonio extends Model
{
    protected $fillable = [
        'user_id',
        'casa_id',
        'contenido',
        'valoracion',
        'fecha_aprobacion',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function casa(): BelongsTo
    {
        return $this->belongsTo(Casa::class, 'id');
    }
}
