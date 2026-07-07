<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casa extends Model
{
    public function propietario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function testimonio(): HasMany
    {
        return $this->hasMany(Testimonio::class, 'id');
    }
}
