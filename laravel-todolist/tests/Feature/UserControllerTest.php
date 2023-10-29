<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    public function testLoginPage(): void
    {
        $this->get('/login')->assertSeeText("Login");
    }


    public function testLoginSucces(): void
    {
        $this->post('/login',[
            "user" => "farhan",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }

    public function testLoginPageForMember(): void
    {
        $this->withSession(["user" => "farhan"])
             ->get('/login')
             ->assertRedirect("/");
    }

    public function testLoginForUserAlreadyLogin(): void
    {
        $this->withSession(["user" => "farhan"])
             ->post('/login',[
                "user" => "farhan",
                "password" => "rahasia",
             ])
             ->assertRedirect("/");
    }

    public function testLoginValidationError(): void
    {
        $this->post('/login',[])->assertSeeText("User or password is empty");
    }


    public function testLoginFailed(): void
    {
        $this->post('/login',[
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout(): void
    {
        $this->withSession(["user" => "farhan"])
             ->post('/logout',[])
             ->assertSessionMissing('user')
             ->assertRedirect('/');
    }

    public function testLogoutForGuest(): void
    {
        $this->post('/logout')
             ->assertRedirect('/login');
    }

}
