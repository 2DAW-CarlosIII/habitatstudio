<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $table = 'testimonios';

    protected $fillable = [
        'casa_id',
        'user_id',
        'contenido',
        'valoracion',
        'fecha_aprobacion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function casa()
    {
        return $this->belongsTo(Casa::class, 'casa_id');
    }

}
