<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testBasicRoute(){
        $this->get('/yp')
            ->assertStatus(200)
            ->assertSeeText("Farhan Yudha Pratama");
    }

    public function testRedirect(){
        $this->get('/farhan')
            ->assertRedirect('/yp');
    }

    public function testFallback(){
        $this->get('/404')
            ->assertSeeText("404");
    }
}
