<?php
// app/Services/OrderService.php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\IngredientWarningRepository;
use App\Repositories\ProductRepository;
use App\Models\Ingredient;
use App\Events\LowStockWarningEvent;


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
        try{
        // Get products with ingredients from the payload
        $products = $this->productRepository->getProductsFromPayload($orderData);

        // Additional logic to check and deduct stock from ingredients
        foreach ($products as $product) {
            foreach ($product->ingredients as $ingredient) {
                //get quantity of current product [ex: 2 Burger]
                $numberOfUnitsWithIngredient = collect($orderData['products'])
                    ->where('product_id', $product->id)
                    ->first()['quantity'];
                // Check if there's enough stock
                //- multiply number of Burger * quantity of cheese needed 
                $quantityToBeDeducted= $numberOfUnitsWithIngredient *  $ingredient->pivot->quantity;
                if ($ingredient->stock >= $quantityToBeDeducted) {
                    // Deduct stock
                    $ingredient->stock -= $quantityToBeDeducted;
                    $ingredient->save();
                    // Check and send warning/notification if percentage match
                    $this->checkIngredientStock($ingredient);
                } else {
                    // Handle insufficient stock scenario
                    throw new \Exception('Insufficient stock for ingredient: ' . $ingredient->name);
                }
            }
        }
            // Create the order
            return $this->orderRepository->createOrder($orderData);
        }catch(\Exception $e)
        {
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
