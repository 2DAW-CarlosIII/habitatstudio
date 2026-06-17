<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'contenido'      => $this->contenido,
            'valoracion'      => $this->valoracion,
            'fecha_aprobacion' => $this->fecha_aprobacion,
            'name'      => $this->name,
            'avatar_url' => $this->avatar_url,
            'nombre_casa' => $this->nombre_casa,


        ];
    }
}
