<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteParameterTest extends TestCase
{
    
    public function testRouteParameter()
    {
        $this->get('/product/shampo')
             ->assertSeeText("Products: shampo");

        $this->get('/product/shampo/items/shampo')
             ->assertSeeText("Products: shampo, item: shampo");
    }

    public function testRouteParameterRegulerExpression()
    {
        $this->get('/categories/shampo')
             ->assertSeeText("404");

        $this->get('/categories/1234')
             ->assertSeeText("Products: 1234");
    }
}
