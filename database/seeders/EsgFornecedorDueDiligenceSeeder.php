<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EsgFornecedorDueDiligence;

class EsgFornecedorDueDiligenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EsgFornecedorDueDiligence::factory()->count(25)->create();
    }
}
