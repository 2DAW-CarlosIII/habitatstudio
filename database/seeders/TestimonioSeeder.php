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


         Testimonio::factory()->count(5)->create();


    }
}
