<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'casa_id',
        'contenido',
        'valoracion',
        'fecha_aprobacion'
    ];
}
