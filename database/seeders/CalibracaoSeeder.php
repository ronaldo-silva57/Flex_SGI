<?php

namespace Database\Seeders;

use App\Models\Calibracao;
use Illuminate\Database\Seeder;

class CalibracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Calibracao::factory()->count(40)->create();
    }
}
