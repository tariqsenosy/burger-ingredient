<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\PlaceOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function placeOrder(PlaceOrderRequest $request): JsonResponse
    {
        try{
        //validate data
        $orderData = $request->validated();

        //calling service with business logic 
        $order = $this->orderService->placeOrder($orderData);

        return response()->json(['order' => $order], 201);
        
        }catch (ValidationException $e) {
            // Return a JSON response with validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
