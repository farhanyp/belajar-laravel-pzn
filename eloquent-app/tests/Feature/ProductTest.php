<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wallet;
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
    public function testOneToMany(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find("FOOD");
        self::assertNotNull($category);

        $products = $category->products;
        self::assertNotNull($products);
        self::assertEquals("FOOD", $products[0]->category_id);
    }

    public function testInsertOneToManyQuery(): void
    {
        $category = new Category();
        $category->id = "FOOD";
        $category->name = "FOOD 1";
        $category->description = "FOOD 1";
        $category->is_active = true;
        $category->save();
        self::assertNotNull($category);

        $product = new Product();
        $product->id = "1";
        $product->name = "Product 1";
        $product->description = "Product Description 1";
        $product->price = 10000;
        $product->stock = 10;
        $category->products()->save($product);

        self::assertNotNull($product);
    }

    public function testRealtionshipQuery(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find("FOOD");
        $products= $category->products;
        self::assertNotNull($products);


        $outOfStockProducts = $category->products()->where('stock', '<=', 0)->get();
        self::assertCount(0, $outOfStockProducts);
    }

    public function testHasOneOfMany(){
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::query()->find("FOOD");
        self::assertNotNull($category);

        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals("1", $cheapestProduct->id);

        // $outOfStockProducts = $category->products()->where('stock', '<=', 0)->get();
        // self::assertCount(0, $outOfStockProducts);
    }
}
