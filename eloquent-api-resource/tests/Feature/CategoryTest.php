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

    public function testResourceCollection(): void
    {
        $this->seed([CategorySeeder::class]);

        $category = Category::all();

        $this->get("/api/categories")
             ->assertStatus(200)
             ->assertJson([
                "data" =>[
                    [
                        "id" => $category[0]->id,
                        "name" => $category[0]->name,
                        "created_at" => $category[0]->created_at->toJSON(),
                        "updated_at" => $category[0]->updated_at->toJSON()
                    ],
                    [
                        "id" => $category[1]->id,
                        "name" => $category[1]->name,
                        "created_at" => $category[1]->created_at->toJSON(),
                        "updated_at" => $category[1]->updated_at->toJSON()
                    ],
                ]
             ]);
    }
}
