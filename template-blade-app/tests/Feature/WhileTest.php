<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WhileTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testWhileLoop(): void
    {
        $this->view('while',["i" => 0])
             ->assertSeeText("The current value is 0")
             ->assertSeeText("The current value is 5")
             ->assertSeeText("The current value is 9");
    }
}
