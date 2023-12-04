<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();
            
            // Quantity here in Grams as per needed business 
            $table->integer('quantity');
            $table->timestamps();
            
            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('ingredient_id')->constrained('ingredients');
            });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ingredients');
    }
};
