<?php

namespace Database\Seeders;

use App\Models\ObjetivoAmbiental;
use Illuminate\Database\Seeder;

class ObjetivoAmbientalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ObjetivoAmbiental::factory()->count(25)->create();
    }
}
