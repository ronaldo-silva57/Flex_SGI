<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ComunicacaoLeitura;

class ComunicacaoLeituraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ComunicacaoLeitura::factory()->count(25)->create();
    }
}
