<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonios = [
            [
                'casa_id' => '1',
                'user_id' => '4',
                'contenido' => 'Hola',
                'valoracion' => '4.5',
                'fecha_aprobacion' => '10/03/2023',
            ],
            [
                'casa_id' => '5',
                'user_id' => '4',
                'contenido' => 'Hola',
                'valoracion' => '4',
                'fecha_aprobacion' => '',
            ],
            [
                'casa_id' => '2',
                'user_id' => '4',
                'contenido' => 'Hola',
                'valoracion' => '2',
                'fecha_aprobacion' => '15/05/2019',
            ],
            [
                'casa_id' => '3',
                'user_id' => '4',
                'contenido' => 'Hola',
                'valoracion' => '5',
                'fecha_aprobacion' => '',
            ],
            [
                'casa_id' => '',
                'user_id' => '4',
                'contenido' => 'Hola',
                'valoracion' => '3.2',
                'fecha_aprobacion' => '10/03/2020',
            ],
        ];
    }
}
