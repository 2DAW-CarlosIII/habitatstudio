<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Casa extends Model
{
    public function propietario(): BelongsTo {

        return $this->belongsTo(User::class, 'propietario_id');
    }
    protected $fillable = [
        'id',
        'nombre_casa',
        'tipo',
        'precio',
        'ubicacion',
        'direccion_completa',
        'instalaciones',
        'descripcion',
        'imagen_url',
        'telefono_propietario',
        'valoracion',
        'propietario_id'
    ];
}
