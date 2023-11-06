<?php

namespace Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function setUp(): void{

        parent::setUp();
        DB::delete("DELETE FROM categories");
    }
    
    public function testTransactionSuccess(): void
    {
        try {
            DB::transaction(function(){
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'GADGET', 'Gadget', 'Gadget Category', '2020-01-01 00:00:00'
                ]);
    
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'FOOD', 'Food', 'Food Category', '2020-01-01 00:00:00'
                ]);
            });
        } catch (QueryException $error) {
            //throw $th;
        }

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(2, $result);
    }

    public function testTransactionFailed(): void
    {
        try {
            DB::transaction(function(){
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'GADGET', 'Gadget', 'Gadget Category', '2020-01-01 00:00:00'
                ]);
    
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'GADGET', 'Food', 'Food Category', '2020-01-01 00:00:00'
                ]);
            });
        } catch (QueryException $error) {
            // Log::info($error);
        }

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(0, $result);
    }

    public function testManualTransactionSuccess(): void
    {
        try {
            DB::beginTransaction();
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'GADGET', 'Gadget', 'Gadget Category', '2020-01-01 00:00:00'
                ]);
    
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'FOOD', 'Food', 'Food Category', '2020-01-01 00:00:00'
                ]);
            DB::commit();
        } catch (QueryException $error) {
            DB::rollBack();
            throw $error;
        }

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(2, $result);
    }

    public function testManualTransactionFailed(): void
    {
        try {
            DB::beginTransaction();
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'GADGET', 'Gadget', 'Gadget Category', '2020-01-01 00:00:00'
                ]);
    
                DB::insert("INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)", [
                    'GADGET', 'Food', 'Food Category', '2020-01-01 00:00:00'
                ]);
            DB::commit();
        } catch (QueryException $error) {
            DB::rollBack();
            // throw $error;
        }

        $result = DB::select("SELECT * FROM categories");
        self::assertCount(0, $result);
    }
}
