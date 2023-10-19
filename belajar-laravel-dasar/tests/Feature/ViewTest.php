<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testRenderingView()
    {
        $this->get('/home')
            ->assertSeeText("Farhan Yudha Pratama");
    }

    public function testRenderingViewNested()
    {
        $this->get('/about')
            ->assertSeeText("Farhan Yudha Pratama");
    }

    public function testViewWithoutRoute()
    {
        $this->view('blog')
            ->assertSeeText("Farhan Yudha Pratama");
    }
}
