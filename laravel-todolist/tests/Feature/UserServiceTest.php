<?php

namespace Tests\Feature;

use App\Services\Impl\UserServicesImpl;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserServicesImpl $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserServicesImpl::class);
    }

    public function testSample(){
        self::assertTrue(true);
    }

    public function testloginSuccess(){
        self::assertTrue($this->userService->login("farhan", "rahasia"));
    }

    public function testWrongUser(){
        self::assertFalse($this->userService->login("farhani", "rahasia"));
    }

    public function testWrongPassword(){
        self::assertFalse($this->userService->login("farhan", "rahasia123"));
    }
}
