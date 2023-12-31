<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
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
        DB::delete("DELETE FROM products");
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
       $this->seed(CategorySeeder::class);
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

    public function testOrdering(){

        $this->insertTableProducts();

        $collection = DB::table("products")->whereNotNull('id')
            ->orderBy("price", "desc")->orderBy("name", 'asc')->get();

        self::assertCount(2, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function testPaging(){

        $this->insertTableProducts();

        $collection = DB::table("categories")
            ->skip(0)
            ->take(2)
            ->get();

        self::assertCount(2, $collection);
        $collection->each(function($item){
            Log::info(json_encode($item));
        });
    }

    public function insertManyCategories(){

        for ($i=0; $i < 100 ; $i++) { 

            DB::table("categories")->insert([
                "id" => "CATEGORY-{$i}",
                "name" => "Category {$i}",
                "created_at" => "2020-10-10 10:10:10",
            ]);

        }
    }

    public function testChunck(){
        $this->insertManyCategories();

        DB::table("categories")->orderBy("id")
            ->chunk(10, function($categories){
                self::assertNotNull($categories);
                Log::info("Start CHUNK");
                $categories->each(function($item){
                    Log::info(json_encode($item));
                });
                Log::info("End CHUNK");
            });
    }

    public function testLazyResult(){
        $this->insertManyCategories();

        $collection = DB::table("categories")->orderBy("id")->lazy(10);

        self::assertNotNull($collection);

        $collection->each(function($item){
            Log::info(json_encode($item));
        });
        
    }

    public function testCursor(){
        $this->insertManyCategories();

        // menggunakan cursor yaite mengambil data secara 1 per 1, hati hati menggunakan cursor jika tidak bakal terkena time out
        $collection = DB::table("categories")->orderBy("id")->cursor();

        self::assertNotNull($collection);

        $collection->each(function($item){
            Log::info(json_encode($item));
        });  
    }

    public function testAggregate(){
        $this->insertTableProducts();

        $result = DB::table('products')->count("id");
        self::assertEquals(2, $result);
        
        $result = DB::table('products')->min("price");
        self::assertEquals(10000000, $result);

        $result = DB::table('products')->max("price");
        self::assertEquals(10000000, $result);

        $result = DB::table('products')->sum("price");
        self::assertEquals(20000000, $result);
    }

    public function testQueryBuilderRaw(){
        $this->insertTableProducts();

        $collection = DB::table("products")->select(
            DB::raw("count(id) as total_product"),
            DB::raw("min(price) as min_product"),
            DB::raw("max(price) as max_product"),
        )->get();

        self::assertEquals(2, $collection[0]->total_product);
        self::assertEquals(10000000, $collection[0]->min_product);
        self::assertEquals(10000000, $collection[0]->max_product);
    }

    public function InsertProductFood(){
        $this->insertTableProducts();

        DB::table("products")->insert([
            'id' => '3', 
            'name' => 'Bakso',
            'category_id' => 'FOOD',
            'price' => 10000000,
        ]);

        DB::table("products")->insert([
            'id' => '4', 
            'name' => 'Nasgor',
            'category_id' => 'FOOD',
            'price' => 10000000,
        ]);
    }

    public function testGrouping(){
        $this->InsertProductFood();

        $collection = DB::table("products")
            ->select('category_id', DB::raw('count(*) as total_product'))
            ->groupBy('category_Id')
            ->orderBy('category_Id', 'desc')
            ->get();

            Log::info($collection);
        self::assertCount(2, $collection);
        self::assertEquals("SMARTPHONE", $collection[0]->category_id);
        self::assertEquals("FOOD", $collection[1]->category_id);


        self::assertEquals(2, $collection[0]->total_product);
        self::assertEquals(2, $collection[1]->total_product);
    }

    public function testGroupingHaving(){
        $this->InsertProductFood();

        $collection = DB::table("products")
            ->select('category_id', DB::raw('count(*) as total_product'))
            ->groupBy('category_Id')
            ->orderBy('category_Id', 'desc')
            ->having(DB::raw('count(*)'), '>', 2)
            ->get();

            Log::info($collection);
        self::assertCount(0, $collection);
    }

    public function testLocking(){
        $this->InsertProductFood();

        DB::transaction(function(){
            $collection = DB::table("products")
                ->where('id', '=', '1')
                ->lockForUpdate()
                ->get();

            self::assertCount(1, $collection);
        });
    }

    public function testPagination(){
        $this->InsertProductFood();

        $paginate = DB::table("categories")->paginate(perPage:2);

        self::assertEquals(1, $paginate->currentPage());
        self::assertEquals(2, $paginate->perPage());
        self::assertEquals(2, $paginate->lastPage());
        self::assertEquals(4, $paginate->total());

        $collection = $paginate->items();

        self::assertCount(2, $collection);
        foreach($collection as $item){
            Log::info(json_encode($item));
        }
    }

    public function testIterationPagination(){
        $this->InsertProductFood();

        $page = 1;
        while(true){
            $paginate = DB::table("categories")->paginate(perPage:1, page: $page);

            if($paginate->isEmpty()){
                break;
            }else{
                $page++;

                $collection = $paginate->items();
        
                self::assertCount(1, $collection);
                foreach($collection as $item){
                    Log::info(json_encode($item));
                }
            }
        }
    }

    public function testCursorPagination(){
        $this->InsertProductFood();

        $cursor = 'id';
        while(true){
            $paginate = DB::table("categories")->orderBy("id")->cursorPaginate(perPage:2, cursor: $cursor);

            foreach($paginate->items() as $item){
                self::assertNotNull($item);
                Log::info(json_encode($item));
            }

            $cursor =  $paginate->nextCursor();
            if($cursor == null){
                break;
            }
        }
    }

}
