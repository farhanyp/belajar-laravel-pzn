<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ForTest extends TestCase
{
    public function testFor(): void
    {
        $this->view('for',["limit" => 3])
             ->assertSeeText("0")
             ->assertSeeText("1")
             ->assertSeeText("2");
    }

    public function testForeach(): void
    {
        $this->view('foreach',["hobbies" => ["mancing", "gaming"]])
             ->assertSeeText("mancing")
             ->assertSeeText("gaming");
    }

    public function testForeachElse(): void
    {
        $this->view('foreach-else',["hobbies" => ["mancing", "gaming"]])
             ->assertSeeText("mancing")
             ->assertDontSeeText("tidak punya hoby");

        $this->view('foreach-else',["hobbies" => []])
             ->assertDontSeeText("mancing")
             ->assertSeeText("tidak punya hoby");
    }
}
