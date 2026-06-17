<?php

namespace Database\Seeders;

use App\Models\Testimonio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonio::truncate();
        foreach (self::$testimonios as $testimonio) {
            Testimonio::insert([
                'fecha_aprobacion' => $testimonio['fecha_aprobacion'],
                'casa_id' => $testimonio['casa_id'],
                'valoracion' => $testimonio['valoracion'],
                'user_id' => $testimonio['user_id'],
                'contenido' => $testimonio['contenido'],
            ]);
        }
    }

    public static $testimonios = array(
        array('fecha_aprobacion' => '2026-06-17', 'casa_id' => 1, 'valoracion' => 4.5, 'user_id' => 1, 'contenido'=> "contenido 1"),
        array('fecha_aprobacion' => '2026-06-18', 'casa_id' => 2, 'valoracion' => 2.0, 'user_id' => 1, 'contenido'=> "contenido 2"),
        array('fecha_aprobacion' => '2026-06-19', 'casa_id' => null, 'valoracion' => 4.9, 'user_id' => 1, 'contenido'=> "contenido 3"),
    );
}
