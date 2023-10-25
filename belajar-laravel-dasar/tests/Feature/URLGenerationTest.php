<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLGenerationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCurrent()
    {
        $this->get('/url/current?name=Yp')->assertSeeText('/url/current?name=Yp');
    }

    public function testNamed()
    {
        $this->get('/url/named')->assertSeeText('/redirect/name/Yp');
    }

    public function testAction()
    {
        $this->get('/url/action')->assertSeeText('/form');
    }
}
