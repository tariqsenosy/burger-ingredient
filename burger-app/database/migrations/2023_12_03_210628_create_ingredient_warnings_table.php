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
        //I created seprate table for answering the following 
        //WTF we need to change 50% to 40%
        //WTF business need more warnings for 25% and 10%
        Schema::create('ingredient_warnings', function (Blueprint $table) {
            $table->id();
            $table->integer('percentage');
            //to ensure that warning sent  only one time , this will be reset with any recharge for the ingredient stock
            //it can done by code level or db level 
            $table->boolean('warning_sent')->default(false);
            $table->timestamps();
            $table->foreignId('ingredient_id')->constrained('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_warnings');
    }
};
