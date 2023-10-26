<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
        $this->get('/session/create')
             ->assertSeeText("OK")
             ->assertSessionHas("userId", "Yp")
             ->assertSessionHas("isMember", "true");
    }

    public function testGetSession()
    {
        $this->withSession([
            'userId' => "Yp",
            'isMember' => "true"
        ])
             ->get('/session/get')
             ->assertSeeText("User: Yp, Member: true");
    }


}
