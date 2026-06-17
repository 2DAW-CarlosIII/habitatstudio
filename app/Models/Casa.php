<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casa extends Model
{
    protected $table = 'casa';

    protected $fillable = [
        'nombre_casa', 'tipo', 'precio', 'ubicacion',
        'direccion_completa', 'instalaciones', 'descripcion',
        'imagen_url', 'propietario_id','telefono_propietario',
        'valoracion'

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function testimonio(): HasMany
    {
        return $this->hasMany(Testimonio::class, 'casa_id');
    }
}
