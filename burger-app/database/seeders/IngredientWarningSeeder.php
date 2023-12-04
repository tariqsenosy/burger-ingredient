<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IngredientWarning;
use App\Models\Ingredient;

class IngredientWarningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = Ingredient::all();
        foreach($ingredients as $ingredient)
        {
            IngredientWarning::create(['ingredient_id' => $ingredient->id, 'percentage' => 50]); // Warning for  by 50%
        }
     }
}
