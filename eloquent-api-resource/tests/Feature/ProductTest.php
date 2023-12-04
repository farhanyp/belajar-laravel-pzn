<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testProduct(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::query()->first();
        $valueExpensive = $product->price > 1000;
        
        $this->get("/api/products/$product->id")
             ->assertStatus(200)
             ->assertJson([
                "value" => [
                    "name" => $product->name,
                    "category" => [
                        "id" => $product->category->id,
                        "name" => $product->category->name,
                    ],
                    "price" => $product->price,
                    "is_expensive" => $product->price > 1000,
                    "created_at" => $product->created_at->toJSON(),
                    "updated_at" => $product->updated_at->toJSON(),
                ]
             ]);
    }

    public function testProductPaging(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $response = $this->get("/api/products-paging")
                         ->assertStatus(200);

        self::assertNotNull($response->json("links"));
        self::assertNotNull($response->json("meta"));
        self::assertNotNull($response->json("data"));
    }

    public function testAdditionalMedatada(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->first();
        $response = $this->get("/api/products-debug/$product->id")
                         ->assertStatus(200)
                         ->assertJson([
                            "author" => "Farhan Yudha Pratama",
                            "data" => [
                                "id" => $product->id,
                                "name" => $product->name,
                                "price" => $product->price,
                            ],
                         ]);

        self::assertNotNull($response->json("author"));
    }

    public function testProductWithHeader(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        
        $this->get("/api/products-paging")
             ->assertStatus(200)
             ->assertHeader("X-Powered-By", "Farhan Yudha Pratama");
    }
}
