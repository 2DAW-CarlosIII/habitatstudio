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
            //'id' => $this->id,
            'contenido' => $this->contenido,
            'valoracion' => $this->valoracion,
            'fecha_aprobacion' => $this->fecha_aprobacion,

            'user' => [
                'name' => $this->user->name,
                'avatar_url' => $this->user->avatar_url,
            ]
        ];
    }
}
