<?php
// app/Repositories/OrderRepository.php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;

class OrderRepository
{
    public function createOrder(array $orderData)
    {
        // Get all product IDs from the order data
        $productIds = collect($orderData['products'])->pluck('product_id')->toArray();

        // Retrieve all products in one query
        $products = Product::whereIn('id', $productIds)->get();

        $orderProducts = [];

        // Loop through the products and prepare data for attaching
        foreach ($products as $product) {
            // Find the corresponding entry in the order data
            $productData = collect($orderData['products'])
                ->where('product_id', $product->id)
                ->first();

            $quantity = $productData['quantity'];
            $unitPrice = $product->price;

            // Prepare data for attaching
            $orderProducts[$product->id] = [
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
            ];
        }

        //total of order 
        $totalSum = collect($orderProducts)->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });
        
        $order = Order::create([
            'total'=>$totalSum,
            'status_id' => OrderStatus::NEW
        ]);

        // Attach all products in one query
        $order->products()->attach($orderProducts);

        return $order;
    }
}
