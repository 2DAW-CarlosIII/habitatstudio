<?php

namespace Database\Seeders;

use App\Models\Casa;
use App\Models\Testimonio;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class TestimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonios')->truncate();
        $casas=Casa::all();
        $users=User::all();
        foreach (self::$testimonios as  $testimonio) {
            foreach ($casas as $casa) {
                $casaElegida=$casa;
        }
        Testimonio::create([
                    'user_id'=>$testimonio['user_id'],
                    'casa_id'=>$casa->id,
                    'contenido'=>$testimonio['contenido'],
                    'valoracion'=>$testimonio['valoracion'],
                    'fecha_aprobacion'=>'2026-06-17 07:56:40'
                ]);
        }



    }
    public static $testimonios=[
        [
            'user_id'=>'1',
            'contenido'=>"testimonios 1",
            'valoracion'=>'3.5',
        ],
        [
            'user_id'=>'2',
            'contenido'=>"testimonios 2",
            'valoracion'=>'4.5',
        ],
        [
            'user_id'=>'3',
            'contenido'=>"testimonios 3",
            'valoracion'=>'5.5',
        ],
        [
            'user_id'=>'4',
            'contenido'=>"testimonios 4",
            'valoracion'=>'2.5',
        ],
    ];
}
