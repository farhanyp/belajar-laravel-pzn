<?php

namespace Tests\Feature;

use App\Services\Impl\UserServicesImpl;
use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserServicesImpl $userService;

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from users");
        $this->userService = $this->app->make(UserServicesImpl::class);
    }

    public function testSample(){
        self::assertTrue(true);
    }

    public function testloginSuccess(){
        $this->seed([UserSeeder::class]);
        
        self::assertTrue($this->userService->login("farhan@gmail.com", "rahasia"));
    }

    public function testWrongUser(){
        self::assertFalse($this->userService->login("farhani", "rahasia"));
    }

    public function testWrongPassword(){
        self::assertFalse($this->userService->login("farhan", "rahasia123"));
    }
}
