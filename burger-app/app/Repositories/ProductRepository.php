<?php
// app/Repositories/ProductRepository.php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getProductsFromPayload(array $orderData)
    {
        //get list of products from payload
        $productIds = collect($orderData['products'])->pluck('product_id')->all();
        //return list of products with ingredients
        return Product::with('ingredients')->whereIn('id', $productIds)->get();
    }
}
