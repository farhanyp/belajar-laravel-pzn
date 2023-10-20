<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NamedRouteTest extends TestCase
{
    public function testNamedRoute(){

        $this->get('/produk/12')->assertSeeText("products/12");

        $this->get('/product-redirect/12')->assertSeeText("products/12");
    }
}
