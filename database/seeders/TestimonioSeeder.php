<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonios = [
            [
                'user_id' => 1,
                'casa_id' => 1,
                'contenido' => 'muchas cosas y muebles',
                'valoracion' => 4,
                'fecha_aprobacion' => '2026-05-17'
            ],
            [
                'user_id' => 2,
                'casa_id' => 2,
                'contenido' => 'muchas cosas y muebles',
                'valoracion' => 3,
                'fecha_aprobacion' => '2026-05-17'
            ],
            [
                'user_id' => 3,
                'casa_id' => null,
                'contenido' => 'muchas cosas y muebles',
                'valoracion' => 5
            ],
            [
                'user_id' => 4,
                'casa_id' => 4,
                'contenido' => 'muchas cosas y muebles',
                'valoracion' => 4.5
            ],
            [
                'user_id' => 5,
                'casa_id' => 5,
                'contenido' => 'muchas cosas y muebles',
                'valoracion' => 4
            ]
        ];
    }
}
