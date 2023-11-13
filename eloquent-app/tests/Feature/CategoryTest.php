<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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

    public function testFind(): void
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find("FOOD");
        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
        self::assertEquals("Food", $category->name);
        self::assertEquals("Food Category", $category->description);
    }

    public function testUpdate(){

        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");

        $category->name = "Food Update";
        $result = $category->update();

        self::assertTrue($result);

    }

    public function testSelect(){

        for($i = 0; $i < 5; $i++){
            $category = new Category();
            $category->id = "$i";
            $category->name = "Category {$i}";
            $category->save();
        }

        $categories = Category::whereNull("description")->get();
        self::assertEquals(5, $categories->count());

        $categories->each(function($category){
            // melakukan select lebih dari satu data, hasil dari Query Builder adalah Collection dari Model nya
            // Jadinya kita bisa melakukan update 
            self::assertNull($category->description);

            $category->description = "Updated";
            $category->update();

            self::assertEquals("Updated", $category->description);
        });

    }

    public function testUpdateMany(){

        $categories = [];
        for ($i=1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "category-{$i}",
                "name" => "category {$i}"
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);

        $categories = Category::whereNull("description", )->update([
            "description" => "Updated"
        ]);

        $total = Category::where("description", '=', "Updated")->count();
        self::assertEquals(10, $total);

    }

    public function testDelete(){

        $this->seed(CategorySeeder::class);

        $category = Category::find("FOOD");
        $result = $category->delete();
        self::assertTrue($result);

        $total = Category::count();
        self::assertEquals(0, $total);
    }
}
