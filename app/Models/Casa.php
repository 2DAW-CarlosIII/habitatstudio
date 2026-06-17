<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casa extends Model
{
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'propietario_id');
    }

    public function testimonios(): HasMany
    {
        return $this->hasMany(Testimonio::class, 'casa_id');
    }
}
