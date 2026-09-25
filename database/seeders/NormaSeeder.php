<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Norma;

class NormaSeeder extends Seeder
{
    public function run(): void
    {
        Norma::factory()->count(20)->create();
    }
}

