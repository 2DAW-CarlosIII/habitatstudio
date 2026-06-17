<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$users = User::all();

        $testimonios = [
            [
                'casa_id' => 2,
                'user_id' => 2,
                'contenido' => 'Prueba',
                'valoracion' => 1.0,
                'fecha_aprobacion' => now(),

            ],
            [
                'casa_id' => 3,
                'user_id' => 3,
                'contenido' => 'Prueba',
                'valoracion' => 1.0,
                'fecha_aprobacion' => now(),
            ],
            [
                'casa_id' => 2,
                'user_id' => 2,
                'contenido' => 'Prueba',
                'valoracion' => 1.0,
                'fecha_aprobacion' => now(),
            ],
            [
                'casa_id' => 4,
                'user_id' => 5,
                'contenido' => 'Prueba',
                'valoracion' => 1.0,
                'fecha_aprobacion' => now(),
            ],
            [
                'casa_id' => null,
                'user_id' => 4,
                'contenido' => 'Prueba',
                'valoracion' => 4.5,
                'fecha_aprobacion' => now(),
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
