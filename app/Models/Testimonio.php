<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonio extends Model
{
    /** @use HasFactory<\Database\Factories\TestimonioFactory> */
    use HasFactory;

  public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
  public function casa(): BelongsTo
    {
        return $this->belongsTo(Casa::class, 'casa_id');
    }


}
