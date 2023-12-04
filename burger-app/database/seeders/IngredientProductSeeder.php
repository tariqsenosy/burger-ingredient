<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Ingredient;


class IngredientProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //select only the burger product
        $firstProduct = Product::first();
        //select all seeds ingredient
        $ingredients = Ingredient::all();

        $firstProduct->ingredients()->attach(1,['quantity'=>150]);//beef
        $firstProduct->ingredients()->attach(2,['quantity'=>30]); //cheese 
        $firstProduct->ingredients()->attach(3,['quantity'=>20]); // onion
    }
}
