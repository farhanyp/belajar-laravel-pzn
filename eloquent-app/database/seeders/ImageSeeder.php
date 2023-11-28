<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image1 = new Image();
        $image1->url = "photo 1";
        $image1->imageable_id = "YP";
        $image1->imageable_type = Customer::class;
        $image1->save();

        $image2 = new Image();
        $image2->url = "photo 2";
        $image2->imageable_id = "1";
        $image2->imageable_type = Product::class;
        $image2->save();
    }
}
