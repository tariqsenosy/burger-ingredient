<?php 
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class OrderTest extends TestCase
{

    /** @test */
    public function it_creates_order_with_product_and_quantity()
    { 
        //create order with only one burger and 
        //assert it's created normally
        $response = $this->postJson('/api/v1/place-order', [
            'products' => [
                ['product_id' => 1, 'quantity' => 1],
            ],
        ]);

        $response->assertStatus(201);

        // Assert order is created in the database
        $this->assertDatabaseHas('orders', [
           'total'=>10, // unit price for burger  
           'status_id'=>1 // new 
        ]);
    }

    /** @test */
    public function it_throws_exception_for_large_quantity()
    {
        $response = $this->postJson('/api/v1/place-order', [
            'products' => [
                ['product_id' => 1, 'quantity' => 1000],
            ],
        ]);
//dd($response->baseResponse->getContent());
$response->assertJsonPath('order.original.error', 'Insufficient stock for ingredient: Beef');
    }

    /** @test */
    public function it_deducts_ingredient_stock_normally()
    {
        
        // Get the current stock of ingredients before creating the order
        $currentBeefStock = Ingredient::where('name', 'Beef')->first()->stock;
        $currentCheeseStock = Ingredient::where('name', 'Cheese')->first()->stock;
        $currentOnionStock = Ingredient::where('name', 'Onion')->first()->stock;

        // Create order with only one burger
        $response = $this->postJson('/api/v1/place-order', [
            'products' => [
                ['product_id' => 1, 'quantity' => 1],
            ],
        ]);

        $response->assertStatus(201);

        // Assert order is created in the database
        $this->assertDatabaseHas('orders', [
            'total' => 10, // unit price for burger
            'status_id' => 1, // new
        ]);

        // Fetch ingredient values from db
        $productIngredient = Product::find(1)->ingredients()->first();//Beef

        // Assert that ingredients are deducted correctly
        $this->assertDatabaseHas('ingredients', [
            'name' => 'Beef',
            'stock' => $currentBeefStock - $productIngredient->pivot->quantity,
        ]);

    }

    /** @test */
    public function it_creates_order_for_product_id_3_and_no_deduction_from_ingredients()
    {
        // Get the current stock of ingredients before creating the order for product_id = 2
        $currentBeefStock = Ingredient::where('name', 'Beef')->first()->stock;
        $currentCheeseStock = Ingredient::where('name', 'Cheese')->first()->stock;
        $currentOnionStock = Ingredient::where('name', 'Onion')->first()->stock;

        // Create order with only one salad (product_id = 2)
        $response = $this->postJson('/api/v1/place-order', [
            'products' => [
                ['product_id' => 3, 'quantity' => 1],
            ],
        ]);

        $response->assertStatus(201);

        // Assert order is created in the database for product_id = 2
        $this->assertDatabaseHas('orders', [
            'total' => 5, // unit price for salad
            'status_id' => 1, // new
        ]);

        // Assert that no ingredients are deducted for product_id = 2
        $this->assertDatabaseHas('ingredients', [
            'name' => 'Beef',
            'stock' => $currentBeefStock,
        ]);

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Cheese',
            'stock' => $currentCheeseStock,
        ]);

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Onion',
            'stock' => $currentOnionStock,
        ]);

        // Assert that product with product_id = 3 has no ingredients
        $this->assertEquals(0, Product::find(3)->ingredients->count());
    }
}
