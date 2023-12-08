<?php
// app/Services/OrderService.php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\IngredientWarningRepository;
use App\Repositories\ProductRepository;
use App\Models\Ingredient;
use App\Events\LowStockWarningEvent;
use DB;


class OrderService
{
    public function __construct(
    private OrderRepository $orderRepository, 
    private IngredientWarningRepository $ingredientWarningRepository,
    private ProductRepository $productRepository)
    {
    }

    public function placeOrder(array $orderData)
    {
        try {
            DB::transaction(function () use ($orderData) {
                // Get products with ingredients from the payload
                $products = $this->productRepository->getProductsFromPayload($orderData);
    
                // Build a single query for stock updates using a CASE statement
                //Avoid case of not sufficient in nth ingredient and need rollback
                $caseStatements = [];
    
                // Additional logic to check and deduct stock from ingredients
                foreach ($products as $product) {
                    foreach ($product->ingredients as $ingredient) {
                        // Get quantity of the current product
                        $numberOfUnitsWithIngredient = collect($orderData['products'])
                            ->where('product_id', $product->id)
                            ->first()['quantity'];
    
                        // Check if there's enough stock
                        $quantityToBeDeducted = $numberOfUnitsWithIngredient * $ingredient->pivot->quantity;
    
                        if ($ingredient->stock >= $quantityToBeDeducted) {
                            // Build a CASE statement for each ingredient
                            $caseStatements[] = "WHEN id = {$ingredient->id} THEN stock - $quantityToBeDeducted";
    
                            // Check and send warning/notification if percentage match
                            $this->checkIngredientStock($ingredient);
                        } else {
                            // Handle insufficient stock scenario
                            throw new \Exception('Insufficient stock for ingredient: ' . $ingredient->name);
                        }
                    }
                }
    
                // one query update 
                $caseStatements = implode(' ', $caseStatements);
                $query = "UPDATE ingredients SET stock = CASE $caseStatements END";
                DB::statement($query);
            });
    
            // Create the order after successful stock updates
            return $this->orderRepository->createOrder($orderData);
        } catch (\Exception $e) {
            // Return a JSON response with the error message
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    
    protected function checkIngredientStock(Ingredient $ingredient)
    {
        //get percentage of current stock over last stock charge 
        $percentage = ($ingredient->stock / $ingredient->last_charge) * 100;
        // Check if the stock is below the warning 
        $warning = $this->ingredientWarningRepository->getWarningByIngredientAndPercentage($ingredient, $percentage);

        if ($warning) {
            // Fire event of Low stock reached 
            event(new LowStockWarningEvent($ingredient));
        }
    }

}
