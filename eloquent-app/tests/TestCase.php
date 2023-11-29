<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void{

        parent::setUp();
        DB::delete('DELETE from persons');
        DB::delete('DELETE from reviews');
        DB::delete('DELETE from taggables');
        DB::delete('DELETE from tags');
        DB::delete('DELETE from images');
        DB::delete('DELETE from customers_likes_products');
        DB::delete('DELETE from products');
        DB::delete('DELETE from categories');
        DB::delete('DELETE from vouchers');
        DB::delete('DELETE from comments');
        DB::delete('DELETE from virtual_accounts');
        DB::delete('DELETE from wallets');
        DB::delete('DELETE from customers');
    }
}
