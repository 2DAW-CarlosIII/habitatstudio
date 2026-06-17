<?php

namespace Database\Seeders;

use App\Models\Testimonio;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class TestimonioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonio1 = Testimonio::create([
            'user_id' => Auth::user()->id,
            'casa_id' => 1,
            'contenido' => 'Este es el contenido del primer testimonio',
            'valoracion' => 4.5,
            'fecha_aprobacion' => '2025/05/2'
        ]);


        $testimonio1 = Testimonio::create([
            'user_id' => Auth::user()->id,
            'casa_id' => null,
            'contenido' => 'Este es el contenido del segundo testimonio',
            'valoracion' => 4,
            'fecha_aprobacion' => null
        ]);



        $testimonio1 = Testimonio::create([
            'user_id' => Auth::user()->id,
            'casa_id' => 2,
            'contenido' => 'Este es el contenido del tercer testimonio',
            'valoracion' => 2,
            'fecha_aprobacion' => null
        ]);



        $testimonio1 = Testimonio::create([
            'user_id' => Auth::user()->id,
            'casa_id' => null,
            'contenido' => 'Este es el contenido del cuarto testimonio',
            'valoracion' => 2.1,
            'fecha_aprobacion' => '2025/05/2'
        ]);




        $testimonio1 = Testimonio::create([
            'user_id' => User::with('bookings')->id,
            'casa_id' => 3,
            'contenido' => 'Este es el contenido del quinto testimonio',
            'valoracion' => 3,
            'fecha_aprobacion' => '2026/04/2'
        ]);
    }
}
