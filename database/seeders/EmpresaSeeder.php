<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Cria uma empresa com dados fixos
        Empresa::factory()->create([
            'codigo'       => 'EMP-001',
            'razao_social' => 'Apex Tecnologia e Sistemas Eletrônicos S.A.',
            'nome_fantasia'=> 'Apex Tech',
            'cnpj'         => '12.345.678/0001-90',
            'ie'           => '123456789',
            'endereco'     => 'Av. das Indústrias, 1500, Distrito Industrial',
            'cidade'       => 'Campinas',
            'estado'       => 'SP',
            'cep'          => '13050-000',
            'telefone'     => '(19) 3789-1000',
            'email'        => 'contato@apextech.com.br',
            'ativo'        => true,
        ]);
    }
}
