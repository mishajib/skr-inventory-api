<?php

namespace Database\Seeders;

use App\Models\ProductStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductStock::factory()->count(10)->create();

        $this->command->info('Product stock table seeded!');
    }
}
