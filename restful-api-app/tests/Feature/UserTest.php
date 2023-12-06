<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRegisterSuccess(): void
    {
        $this->post('/api/users',[
            "username" => "farhan",
            "password" => "farhan",
            "name" => "farhan",
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "username" => "farhan",
                    "name" => "farhan"
                ]
            ]);
    }

    public function testRegisterFailed(): void
    {
        $this->post('/api/users',[
            "username" => "",
            "password" => "",
            "name" => "",
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "username" => ["The username field is required."],
                    "password" => ["The password field is required."],
                    "name" => ["The name field is required."]
                ]
            ]);
    }

    public function testRegisterWithUsernameExists(): void
    {
        $this->testRegisterSuccess();

        $this->post('/api/users',[
            "username" => "farhan",
            "password" => "farhan",
            "name" => "farhan",
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "username" => ["username already registered"],
                ]
            ]);
    }

    public function testLoginSuccess(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post('/api/users/login',[
            "username" => "test",
            "password" => "test"
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "test"
                ]
            ]);
    }

    public function testLoginFailedWithUsernameNotFound(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post('/api/users/login',[
            "username" => "test1",
            "password" => "test"
        ])->assertStatus(200)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ],
                ]
            ]);
    }

    public function testLoginFailedWithPassword(): void
    {

        $this->post('/api/users/login',[
            "username" => "test",
            "password" => "test1"
        ])->assertStatus(200)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ],
                ]
            ]);
    }

    public function testGetSuccess(): void
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current',[
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    'username' => "test",
                    'name' => "test",
                ]
        ]);
    }

    public function testGetUnauthorized(): void
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current')->assertStatus(401)
            ->assertJson([
                "errors" => [
                    'message' => [
                        'unauthorized'
                    ],
                ]
        ]);
    }

    public function testGetInvalid(): void
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current',[
            'Authorization' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    'message' => [
                        'unauthorized'
                    ],
                ]
        ]);
    }

    public function testUpdateName(): void
    {
        $this->seed([UserSeeder::class]);

        $oldUser = User::query()->where("username", "test")->first();

        $this->patch('/api/users/current',[
            "name" => "farhan"
        ],
        [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "farhan",
                ]
            ]);

        $newUser = User::query()->where("username", "test")->first();

        self::assertNotEquals($oldUser->name, $newUser->name);
    }

    public function testUpdatePassword(): void
    {
        $this->seed([UserSeeder::class]);

        $oldUser = User::query()->where("username", "test")->first();

        $this->patch('/api/users/current',[
            "password" => "farhan"
        ],
        [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test"
                ]
            ]);

        $newUser = User::query()->where("username", "test")->first();

        self::assertNotEquals($oldUser->password, $newUser->password);
    }


    public function testUpdateFailed(): void
    {
        $this->seed([UserSeeder::class]);

        $this->patch('/api/users/current',[
            "password" => "farhan"
        ],
        [
            'Authorization' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ]);
    }

    public function testLogoutSuccess(): void
    {
        $this->seed([UserSeeder::class]);

        $this->delete(uri:'/api/users/logout',headers:[
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => true
        ]);

        $user = User::query()->where("username", "test")->first();
        self::assertNull($user->token);
    }
    
    public function testLogoutFailed(): void
    {
        $this->seed([UserSeeder::class]);

        $this->delete(uri:'/api/users/logout')
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
        ]);
    }
}
