<?php

namespace Database\Seeders;

use App\Models\Clausula;
use Illuminate\Database\Seeder;

class ClausulaSeeder extends Seeder
{
     public function run(): void
    {
        Clausula::factory()->count(25)->create();
    }
}