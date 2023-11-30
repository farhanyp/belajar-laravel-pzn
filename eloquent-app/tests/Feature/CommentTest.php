<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommentTest extends TestCase
{

    public function setUp(): void{

        parent::setUp();
        DB::delete('DELETE from comments');
        
    }
    
    public function testCreateComments(): void
    {
        $comment = new Comment();
        $comment->email = "farhan@gmail.com";
        $comment->title = "Sample Title";
        $comment->comment = "Sample Comment";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->commentable_id = "1";
        $comment->commentable_type = Product::class;
        $comment->save();

        self::assertNotNull($comment->id);
    }

    public function testDefaultAttributeValues(): void
    {
        $comment = new Comment();
        $comment->email = "farhan@gmail.com";
        $comment->created_at = new \DateTime();
        $comment->updated_at = new \DateTime();
        $comment->commentable_id = "1";
        $comment->commentable_type = Product::class;
        $comment->save();

        self::assertNotNull($comment->title);
        self::assertNotNull($comment->comment);
    }
}
