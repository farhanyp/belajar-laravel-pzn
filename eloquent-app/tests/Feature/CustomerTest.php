<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CustomerSeeder;
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
}
