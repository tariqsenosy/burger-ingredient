<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create(['name' => 'Burger', 'price' => 10.00]);
        Product::create(['name' => 'Water', 'price' => 1.50]);
        Product::create(['name' => 'Salad', 'price' => 5.00]);
    }
}
