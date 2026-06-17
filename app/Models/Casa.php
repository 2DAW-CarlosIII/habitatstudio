<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Casa extends Model
{
    protected $table='casas';
    protected $fillable = ['nombre_casa','tipo','precio','ubicacion','direccion_completa','instalaciones','descripcion','imagen_url','telefono_propietario','propietario_id'];

    public function propietario():BelongsTo{
        return $this->belongsTo(User::class,'propietario_id','id');
    }
    public function testimonios():HasMany{
        return $this->hasMany(Testimonio::class,'casa_id','id');
    }

}
