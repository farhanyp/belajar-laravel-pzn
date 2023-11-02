<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CssClassTest extends TestCase
{
    
    public function test_example(): void
    {
        $this->view('css-class',["hobbies" =>[
            [
                "name" => "coding",
                "love" => true
            ],
            [
                "name" => "love",
                "love" => true
            ],
            ]])->assertSee('<li class="red">coding</li>', false)
               ->assertSee('<li class="red bold">love</li>', false);
    }
}
