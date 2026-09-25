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
            'razao_social' => 'Minha Empresa Ltda',
            'nome_fantasia'=> 'Flex SGI',
            'cnpj'         => '12.345.678/0001-99',
            'ie'           => '123456789',
            'endereco'     => 'Rua Exemplo, 123',
            'cidade'       => 'São Paulo',
            'estado'       => 'SP',
            'cep'          => '01000-000',
            'telefone'     => '(11) 99999-9999',
            'email'        => 'contato@flexsgi.com.br',
            'ativo'        => true,
        ]);
    }
}
