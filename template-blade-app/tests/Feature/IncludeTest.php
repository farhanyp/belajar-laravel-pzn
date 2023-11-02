<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeTest extends TestCase
{
    public function testInculde(): void
    {
        $this->view('include',[])
             ->assertSeeText("Tidak mengirim title")
             ->assertSeeText("mingirim desc")
             ->assertDontSeeText("Tidak mengirim desc")
             ->assertSeeText("ini child dari include");
    }

    public function testInculdeWithData(): void
    {
        $this->view('include',["title" => "mingrim title"])
             ->assertSeeText("mingrim title")
             ->assertDOntSeeText("Tidak mengirim title")
             ->assertSeeText("mingirim desc")
             ->assertDontSeeText("Tidak mengirim desc")
             ->assertSeeText("ini child dari include");
    }
}
