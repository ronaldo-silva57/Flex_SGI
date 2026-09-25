<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fornecedor;
use App\Models\Empresa; // se houver

class FornecedorSeeder extends Seeder
{
    public function run(): void
    {
        Fornecedor::factory(20)->create();
    }
}