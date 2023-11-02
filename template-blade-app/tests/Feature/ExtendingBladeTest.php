<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExtendingBladeTest extends TestCase
{
    public function testExtendingBlade(): void
    {
        $this->view('extending', ["name" => "Eko"])
             ->assertSeeText("Hello Yp");
    }
}
