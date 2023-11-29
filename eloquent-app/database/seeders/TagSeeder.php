<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tag = new Tag();
        $tag->id = "yp";
        $tag->name = "Farhan Yudha Pratama";
        $tag->save();

        $product = Product::query()->find("1");
        $product->tags()->attach($tag);

        $voucher = Voucher::query()->first();
        $voucher->tags()->attach($tag);
    }
}
