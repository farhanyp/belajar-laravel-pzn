<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    
    
    public function testOneToOne(): void
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::query()->find("YP");
        self::assertNotNull($customer);

        $wallet = $customer->wallet;
        self::assertNotNull($wallet);
    }

    public function testInsertOneToOneQuery(): void
    {
        $customer = new Customer();
        $customer->id = "YP";
        $customer->name = "Yp";
        $customer->email = "Yp@gmail.com";
        $customer->save();
        self::assertNotNull($customer);

        $wallet = new Wallet();
        $wallet->amount = 100000;
        $customer->wallet()->save($wallet);

        self::assertNotNull($wallet);

        Log::info($wallet);
    }

    public function testHasOneThrough(): void
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::query()->find("YP");
        self::assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        self::assertNotNull($virtualAccount);
        self::assertEquals("BCA", $virtualAccount->bank);
        Log::info($virtualAccount);
    }

    public function testManyToMany(){
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::query()->find("YP");
        self::assertNotNull($customer);

        // menambahkan relasi many to many
        $customer->likeProducts()->attach("1");

        $products = $customer->likeProducts;
        self::assertCount(1, $products);
        self::assertEquals("1", $products[0]->id);
    }

    public function testManyToManyDetach(){
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::query()->find("YP");
        self::assertNotNull($customer);

        // menambahkan relasi many to many
        $customer->likeProducts()->detach("1");

        $products = $customer->likeProducts;
        self::assertCount(0, $products);
    }

    public function testPivotAttribute(){
        $this->testManyToMany();

        $customer = Customer::query()->find("YP");
        $products = $customer->likeProducts;

        foreach($products as $product){
            $pivot = $product->pivot;
            Log::info($pivot);
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testPivotAttributeWithCondition(){
        $this->testManyToMany();

        $customer = Customer::query()->find("YP");
        $products = $customer->likeProductsLastWeek;

        foreach($products as $product){
            $pivot = $product->pivot;
            Log::info($pivot);
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }
}
