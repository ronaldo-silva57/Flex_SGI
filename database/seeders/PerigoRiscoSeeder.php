<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerigoRisco;

class PerigoRiscoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerigoRisco::factory()->count(20)->create();
    }
}