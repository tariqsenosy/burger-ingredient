<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OrderController;



// naming with v1 give us the flexibility for versioning 
Route::prefix('v1')->group(function (){
    Route::post('/place-order', [OrderController::class, 'placeOrder']);
});

