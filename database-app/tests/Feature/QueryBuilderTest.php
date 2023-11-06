<?php

namespace Tests\Feature;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

use function Laravel\Prompts\select;

class QueryBuilderTest extends TestCase
{
    public function setUp(): void{

        parent::setUp();
        DB::delete("DELETE FROM categories");
    }
    
    public function testQueryBuilderInsert(): void
    {
        DB::table("categories")->insert([
            'id' => 'GADGET',
            'name' => 'Gadget'
        ]);

        DB::table("categories")->insert([
            'id' => 'FOOD',
            'name' => 'Food'
        ]);

        $result = DB::select("SELECT COUNT(id) as total FROM categories");

        self::assertEquals(2, $result[0]->total);
    }

    public function testInsert(){

        DB::table("categories")->insert([
            'id' => 'GADGET',
            'name' => 'Gadget',
        ]);

        DB::table("categories")->insert([
            'id' => 'FOOD',
            'name' => 'Food',
        ]);

        $result = DB::select("SELECT COUNT(id) as total FROM categories");

        self::assertEquals(2, $result[0]->total);
    }

    public function testSelect(){
        $this->testInsert();

        $collection = DB::table("categories")->select(["id", "name"])->get();
        self::assertNotNull($collection);

        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function insertCategories(){
        DB::table("categories")->insert([
            "id" => "SMARTPHONE",
            "name" => "Smartphone",
            "created_at" => "2020-10-10 10:10:10",
        ]);

        DB::table("categories")->insert([
            "id" => "FOOD",
            "name" => "Food",
            "created_at" => "2020-10-10 10:10:10",
        ]);

        DB::table("categories")->insert([
            "id" => "LAPTOP",
            "name" => "Laptop",
            "created_at" => "2020-10-10 10:10:10",
        ]);

        DB::table("categories")->insert([
            "id" => "FASHION",
            "name" => "Fashion",
            "created_at" => "2020-10-10 10:10:10",
        ]);
    }

    public function testWhere(){

        $this->insertCategories();

        $collection = DB::table("categories")->orWhere(function(Builder $builder){
            $builder->where('id','=','SMARTPHONE');
            $builder->orWhere('id','=','LAPTOP');
        })->get();

        self::assertCount(2, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testWhereBetweenMethod(){

        $this->insertCategories();

        $collection = DB::table("categories")->whereBetween('created_at', ['2020-10-10 00:00:00', '2020-10-10 23:59:59'])->get();

        self::assertCount(4, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testWhereInMethod(){

        $this->insertCategories();

        $collection = DB::table("categories")->whereIn('id', ['SMARTPHONE', 'LAPTOP'])->get();

        self::assertCount(2, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testWhereNullMethod(){

        $this->insertCategories();

        $collection = DB::table("categories")->whereNull('description')->get();

        self::assertCount(4, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testWhereDateMethod(){

        $this->insertCategories();

        $collection = DB::table("categories")->whereDate('created_at', '2020-10-10')->get();

        self::assertCount(4, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testUpdate(){

        $this->insertCategories();

        DB::table("categories")->where('id', 'SMARTPHONE')->update([
            'name' => "HANDPHONE"
        ]);

        $collection = DB::table("categories")->where('name', '=', 'HANDPHONE')->get();

        self::assertCount(1, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testUpdateOrInsert(){

        $this->insertCategories();

        DB::table("categories")->updateOrInsert([
            'id' => 'VOUCHER'
        ],[
            'name' => 'Voucher',
            'description' => 'Ticket and Voucher',
            'created_at' => '2020-10-10 10:10:10',
        ]);

        $collection = DB::table("categories")->where('name', '=', 'VOUCHER')->get();

        self::assertCount(1, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testDelete(){

        $this->insertCategories();

        DB::table("categories")->where(['id' => 'SMARTPHONE' ])->delete();

        $collection = DB::table("categories")->where('name', '=', 'SMARTPHONE')->get();

        self::assertCount(0, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function insertTableProducts(){

        $this->insertCategories();

        DB::table("products")->insert([
            'id' => '1', 
            'name' => 'iPhone 14 Pro Max',
            'category_id' => 'SMARTPHONE',
            'price' => 10000000,
        ]);

        DB::table("products")->insert([
            'id' => '2', 
            'name' => 'Samsung Galaxy S21 Ultra',
            'category_id' => 'SMARTPHONE',
            'price' => 10000000,
        ]);
    }

    public function testJoin(){

        $this->insertTableProducts();

        $collection = DB::table("products")
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.id', 'products.name', 'categories.name as category_name', 'products.price')
            ->get();

        self::assertCount(2, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }
}
