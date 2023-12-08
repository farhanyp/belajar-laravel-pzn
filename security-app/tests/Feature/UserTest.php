<?php

namespace Tests\Feature;

use App\Models\User;
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

    public function testLogin(): void
    {
        $this->seed(UserSeeder::class);

        $this->get('/users/login?email=farhan@gmail.com&password=rahasia')
             ->assertRedirect('/users/current');
        
        $this->get('/users/login?email=wrong&password=wrong')
             ->assertSeeText('Wrong credentials');     
    }

    public function testCurrent(): void
    {
        $this->seed(UserSeeder::class);

        $this->get('/users/current')
             ->assertSeeText('Hello Guest');
        
        $user = User::query()->where("email", "farhan@gmail.com")->first();
        $this->actingAs($user)
             ->get('/users/current')
             ->assertSeeText('Hello Farhan Yudha Pratama');     
    }
}
