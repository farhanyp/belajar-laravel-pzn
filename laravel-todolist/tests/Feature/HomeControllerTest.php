<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testMember(): void
    {
        $this->withSession([
            "user" => "farhan"
        ])->get('/')->assertRedirect('/todolist');
    }

    public function testGuest(): void
    {
        $this->get('/')->assertRedirect('/login');
    }
}
