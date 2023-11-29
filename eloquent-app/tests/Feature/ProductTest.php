<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
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

        $expensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($expensiveProduct);
        self::assertEquals("2", $expensiveProduct->id);
    }

    public function testOneToManyPolymorphic(){
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::query()->find("1");
        self::assertNotNull($product);

        $comments = $product->comments;
        Log::info($comments);
        foreach($comments as $comment){
            self::assertEquals(Product::class, $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);

        }
    }

    public function testOneOfManyPolymorphic(){
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::query()->find("1");
        self::assertNotNull($product);

        $latestComment = $product->latestComment;
        self::assertNotNull($latestComment);

        $oldestComment = $product->oldestComment;
        self::assertNotNull($oldestComment);
    }

    public function testManyToManyPolymorphic(){
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class]);

        $product = Product::query()->find("1");
        $tags = $product->tags;
        self::assertNotNull($tags);
        self::assertCount(1, $tags);

        foreach($tags as $tag){

            self::assertNotNull($tag->id);
            self::assertNotNull($tag->name);

            $vouchers = $tag->vouchers;
            self::assertNotNull($vouchers);
            self::assertCount(1, $vouchers);
        }
    }
}
