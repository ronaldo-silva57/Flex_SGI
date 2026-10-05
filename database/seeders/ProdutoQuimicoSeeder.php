<?php

namespace Database\Seeders;

use App\Models\ProdutoQuimico;
use Illuminate\Database\Seeder;

class ProdutoQuimicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProdutoQuimico::factory()->count(25)->create();
    }
}
