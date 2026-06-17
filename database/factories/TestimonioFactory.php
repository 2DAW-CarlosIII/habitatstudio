<?php

namespace Database\Factories;

use App\Models\Casa;
use App\Models\Testimonio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonio>
 */
class TestimonioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::query()->inRandomOrder()->value('id');
        $casaId = Casa::query()->inRandomOrder()->value('id');
        return [

            'user_id' => $userId,
            'casa_id' =>fake()->randomElement([$casaId, null]),

            'contenido' => fake()->text(),
            'valoracion' => fake()->randomFloat(1, 0, 5),
            'fecha_aprobacion' => fake()->randomElement([fake()->date(), null]),

        ];
    }
}

