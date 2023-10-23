<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    
    public function testResponse()
    {
        $this->get('/response/hello')->assertSeeText("Hello Response");
    }

    public function testHeader()
    {
        $this->get('/response/header')
             ->assertStatus(200)
             ->assertSeeText("Farhan")
             ->assertSeeText("Yp")
             ->assertHeader("Content-Type", "application/json")
             ->assertHeader("Author", "Farhan Yudha Pratama")
             ->assertHeader("App", "Belajar Laravel");
    }

    public function testResponseView()
    {
        $this->get('/response/view')->assertSeeText("Farhan Yudha Pratama");
    }

    public function testResponseJson()
    {
        $this->get('/response/json')->assertJson([
            "firstname" => "Farhan",
            "lastname" => "Yp",
        ]);
    }

    public function testResponseFile()
    {
        $this->get('/response/file')->assertHeader('Content-Type', 'image/jpeg');
    }

    public function testResponseDownload()
    {
        $this->get('/response/download')->assertDownload('Ada Wong - Resident Evil 4 Remake.jpg');
    }
}
