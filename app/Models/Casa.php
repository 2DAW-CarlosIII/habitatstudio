<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casa extends Model
{

    protected $table = "casas";

    protected $fillable = [
        'nombre_casa',
        'tipo',
        'precio',
        'ubicacion'
    ];

    public function testimonios(): HasMany {
        return $this->hasMany(Testimonio::class);
    }
}
