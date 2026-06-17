<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casa extends Model
{

    protected $table = "casas";

    protected $fillable = [
        'nombre_casa',
        'tipo',
        'precio',
        'ubicacion',
        'propietario_id'
    ];

    public function testimonios(): HasMany {
        return $this->hasMany(Testimonio::class, 'casa_id');
    }

    public function bookings(): HasMany {
        return $this->hasMany(Booking::class, 'casa_id');
    }

    public function propietario(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
