<?php

namespace Database\Seeders;

use App\Models\EquipamentoMedicao;
use Illuminate\Database\Seeder;

class EquipamentoMedicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EquipamentoMedicao::factory()->count(25)->create();
    }
}
