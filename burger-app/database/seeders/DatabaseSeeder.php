<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

  

class DatabaseSeeder extends Seeder

{
    /**

     * Seed the application's database.

     */

    public function run(): void

    {
        $this->call(ProductSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(IngredientSeeder::class);
        $this->call(IngredientProductSeeder::class);
        $this->call(IngredientWarningSeeder::class);
        
    }

}