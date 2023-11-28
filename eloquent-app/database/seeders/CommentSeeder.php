<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCommentsForProducts();
        $this->createCommentsForVouchers();
    }

    private function createCommentsForProducts(): void{
        $product = Product::query()->find("1");

        $comment = new Comment();
        $comment->email = "yp@gmail.com";
        $comment->title = "Title";
        $comment->commentable_id = $product->id;
        $comment->commentable_type = Product::class;
        $comment->save();
    }

    private function createCommentsForVouchers(): void{
        $voucher = Voucher::query()->first();

        $comment = new Comment();
        $comment->email = "yp@gmail.com";
        $comment->title = "Title";
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = Voucher::class;
        $comment->save();
    }
}
