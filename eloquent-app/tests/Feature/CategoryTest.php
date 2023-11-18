<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    
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

    public function testDeleteMany(){

        $categories = [];
        for ($i=1; $i <= 10; $i++) {
            $categories[] = [
                "id" => "category-{$i}",
                "name" => "category {$i}"
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);
        
        $total = Category::count();
        self::assertEquals(10, $total);

        Category::whereNull("description")->delete();

        $total = Category::count();
        self::assertEquals(0, $total);
    }

    public function testCreate(): void
    {
        $request = [
            "id" => "FOOD",
            "name" => "Food",
            "description" => "Food Category",
        ];

        $category = new Category($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    public function testUpdateMass(): void
    {
        $this->seed(CategorySeeder::class);

        $request = [
            "name" => "Food Update",
            "description" => "Food Update",
        ];

        $category = Category::find("FOOD");
        $category->fill($request);
        
        self::assertNotNull($category->id);
    }

    // tes untuk global scope
    // public function testGlobalScope(): void
    // {
    //     $category = new Category();
    //     $category->id = "FOOD";
    //     $category->name = "Food";
    //     $category->description = "Food Category";
    //     $category->is_active = false;
    //     $category->save();

    //     // $category = Category::query()->find("FOOD");
    //     // self::assertNotNull($category);

    //     $category = Category::query()->withoutGlobalScope([IsActiveScope::class])->find("FOOD");
    //     // self::assertNotNull($category);
    //     Log::info($category);
    // }
}
