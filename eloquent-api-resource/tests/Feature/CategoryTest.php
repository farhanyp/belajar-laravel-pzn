<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testResource(): void
    {
        $this->seed([CategorySeeder::class]);

        $category = Category::query()->first();

        $this->get("/api/categories/$category->id")
             ->assertStatus(200)
             ->assertJson([
                "data" =>[
                    "id" => $category->id,
                    "name" => $category->name,
                    "created_at" => $category->created_at->toJSON(),
                    "updated_at" => $category->updated_at->toJSON()
                ]
             ]);
    }
}
