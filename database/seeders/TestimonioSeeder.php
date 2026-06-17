<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $testimonios = [
            [
                'user_id' => 1,
                'casa_id' => null,
                'contenido' => 'contenido de prueba',
                'valoracion' => 4.5,
                'fecha_aprobacion' => '2026-06-17 07:42:26'
            ],
            [
                'user_id' => 2,
                'casa_id' => 2,
                'contenido' => 'contenido de prueba 2',
                'valoracion' => 3.5,
                'fecha_aprobacion' => '2026-06-17 08:42:26'
            ],
            [
                'user_id' => 3,
                'casa_id' => 3,
                'contenido' => 'contenido de pruebaasdasdasd',
                'valoracion' => 3.2,
                'fecha_aprobacion' => '2026-06-17 10:42:26'
            ],
            [
                'user_id' => 4,
                'casa_id' => 1,
                'contenido' => 'contenido de prueba asdasdasdasdasdasd',
                'valoracion' => 5.0,
                'fecha_aprobacion' => '2026-06-17 12:42:26'
            ],
            [
                'user_id' => 5,
                'casa_id' => 4,
                'contenido' => 'contenido de prueba asdasdasd',
                'valoracion' => 3.3,
                'fecha_aprobacion' => '2026-06-17 01:42:26'
            ],
        ];

        foreach ($testimonios as $testimonio) {
            DB::table('testimonios')->insert(array_merge($testimonio, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
