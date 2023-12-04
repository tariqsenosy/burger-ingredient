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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // We can calcluate total everytime from db , However I created here for lower number of quereis as AWS costs a lot 
            $table->decimal('total', 10, 2);
            //for soft deletes , it depends on the business
            $table->boolean('is_deleted')->default(false);
            //order status  in new table for flexibility
            $table->foreignId('status_id')->constrained('order_statuses')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
