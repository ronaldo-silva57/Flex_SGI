<?php

namespace Database\Seeders;

use App\Models\IndicadorAmbiental;
use Illuminate\Database\Seeder;

class IndicadorAmbientalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IndicadorAmbiental::factory()->count(25)->create();
    }
}
