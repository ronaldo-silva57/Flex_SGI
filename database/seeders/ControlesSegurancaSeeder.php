<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ControleSeguranca;

class ControlesSegurancaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ControleSeguranca::factory()->count(25)->create();
    }
}
