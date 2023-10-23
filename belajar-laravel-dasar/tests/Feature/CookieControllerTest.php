<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    public function testCreateCookie()
    {
        $this->get('/cookie/set')
             ->assertCookie('User-Id', 'laptop')
             ->assertCookie('Is-Member', 'true');
    }

    public function testGetCookie()
    {
        $this->withCookie('User-Id', 'Farhan')
             ->withCookie('Is-Member', 'true')
             ->get('/cookie/get')
             ->assertJson([
                'userId' => "Farhan",
                'isMember' => "true",
             ]);
    }
}
