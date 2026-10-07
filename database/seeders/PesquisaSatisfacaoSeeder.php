<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesquisaSatisfacao;

class PesquisaSatisfacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PesquisaSatisfacao::factory()->count(15)->create();
    }
}
