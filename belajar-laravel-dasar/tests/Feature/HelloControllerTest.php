<?php

namespace Tests\Feature;

use App\Services\HelloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloControllerTest extends TestCase
{
    public function testHelloController()
    {
        $this->get('/controller/hello/yp')
             ->assertSeeText("Hello yp");
    }

    public function testRequest()
    {
        $this->get('/controller/hello/request',[
            'Accept' => 'plain/text'
        ])->assertSeeText("controller/hello/request")
            ->assertSeeText("http://localhost/controller/hello/request")
            ->assertSeeText("GET")
            ->assertSeeText("plain/text");
    }
}
