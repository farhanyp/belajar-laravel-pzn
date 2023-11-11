<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    public function setUp(): void{

        parent::setUp();
        DB::delete('DELETE from categories');
        
    }
    
    public function testInsert(): void
    {
        $category = new Category();
        $category->id = "GADGET";
        $category->name = "Gadget";
        $result = $category->save();

        self::assertTrue($result);
    }

    public function testInsertMany(): void
    {
        $categories = [];
        for ($i=1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "category-{$i}",
                "name" => "category {$i}"
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);

        $count = Category::count();
        self::assertEquals(10, $count);

    }
}
