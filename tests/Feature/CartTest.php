<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_product_to_cart_and_read_it_back(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Face Care',
            'slug' => 'face-care',
            'description' => 'Face care products',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Hydrating Primer',
            'slug' => 'hydrating-primer',
            'description' => 'Hydrating primer for smooth skin',
            'price' => 38.00,
            'compare_price' => 45.00,
            'stock_quantity' => 10,
            'sku' => 'PRM-100',
            'status' => 'active',
            'featured' => true,
            'views' => 0,
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Added to cart',
            ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $cartResponse = $this->getJson('/api/v1/cart');

        $cartResponse
            ->assertOk()
            ->assertJsonPath('count', 1)
            ->assertJsonPath('total_items', 1);
    }

    public function test_adding_same_product_increases_quantity(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Makeup',
            'slug' => 'makeup',
            'description' => 'Makeup products',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Bold Lipstick',
            'slug' => 'bold-lipstick',
            'description' => 'Long lasting lipstick',
            'price' => 22.00,
            'compare_price' => 28.00,
            'stock_quantity' => 5,
            'sku' => 'LIP-200',
            'status' => 'active',
            'featured' => false,
            'views' => 0,
        ]);

        Sanctum::actingAs($user);

        $this->postJson('/api/v1/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertCreated();

        $this->postJson('/api/v1/cart', [
            'product_id' => $product->id,
            'quantity' => 2,
        ])->assertCreated();

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }
}
