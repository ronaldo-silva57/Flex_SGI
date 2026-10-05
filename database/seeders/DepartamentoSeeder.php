<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;
use App\Models\Empresa;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empresa::all()->each(function ($empresa) {
            Departamento::factory(20)->create([
                'empresa_id' => $empresa->id,
            ]);
        });
    }
}
