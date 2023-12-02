<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
    
    public function testLoginSuccess(): void
    {
        $response = $this->post('/login', [
            "username" => "farhan",
            "password" => "farhan123",
        ]);

        $response->assertStatus(200);
    }

    public function testLoginFailed(): void
    {
        $response = $this->post('/login', [
            "username" => "",
            "password" => "",
        ]);

        $response->assertStatus(400);
    }
}
