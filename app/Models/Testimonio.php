<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonio extends Model
{
    protected $table = 'testimonio';

    protected $fillable = [
        'casa_id', 'user_id', 'contenido',
        'valoracion', 'fecha_aprobacion'

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function casa(): BelongsTo
    {
        return $this->belongsTo(Casa::class);
    }

}
