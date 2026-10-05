<?php

namespace Database\Seeders;

use App\Models\AvaliacaoFornecedor;
use Illuminate\Database\Seeder;

class AvaliacaoFornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AvaliacaoFornecedor::factory()->count(25)->create();
    }
}
