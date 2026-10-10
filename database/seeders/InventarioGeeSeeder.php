<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventarioGee;

class InventarioGeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InventarioGee::factory()->count(15)->create();
    }
}
