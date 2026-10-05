<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use App\Models\User;
use App\Models\NaoConformidadeAmbiental;

class NaoConformidadeAmbientalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NaoConformidadeAmbiental::factory()->count(20)->create();
    }
}
