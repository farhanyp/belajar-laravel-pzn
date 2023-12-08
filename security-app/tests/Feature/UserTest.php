<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testAuth(): void
    {
        $this->seed(UserSeeder::class);

        $success = Auth::attempt([
            "name" => "Farhan Yudha Pratama",
            "password" => "rahasia",
        ], true);

        self::assertTrue($success);

        $user = Auth::user();
        self::assertNotNull($user);
    }

    public function testGuest(): void
    {
        $user = Auth::user();
        self::assertNull($user);
    }
}
