<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //default asked by the business
        // we use grams here 
        Ingredient::create(['name' => 'Beef', 'stock' => 20000 , 'last_charge'=>20000]);
        Ingredient::create(['name' => 'Cheese', 'stock' => 5000, 'last_charge'=>5000]);
        Ingredient::create(['name' => 'Onion', 'stock' => 1000, 'last_charge'=>1000]);
    }
}
