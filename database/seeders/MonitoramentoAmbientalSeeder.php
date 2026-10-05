<?php

namespace Database\Seeders;

use App\Models\MonitoramentoAmbiental;
use Illuminate\Database\Seeder;

class MonitoramentoAmbientalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MonitoramentoAmbiental::factory()->count(60)->create();
    }
}
