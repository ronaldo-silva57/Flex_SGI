<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RiscoOportunidade;

class RiscoOportunidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    {
        // Cria 20 registros de riscos/oportunidades
        RiscoOportunidade::factory()->count(20)->create();
    }
    }
}
