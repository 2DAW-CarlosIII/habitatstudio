<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonio extends Model
{
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function casa(): BelongsTo
    {
        return $this->belongsTo(Casa::class, 'id');
    }
}
