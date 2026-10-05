<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EpiUsuario;

class EpiUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EpiUsuario::factory(25)->create();
    }
}
