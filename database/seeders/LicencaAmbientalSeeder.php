<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LicencaAmbiental;

class LicencaAmbientalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LicencaAmbiental::factory()->count(15)->create();
    }
}
