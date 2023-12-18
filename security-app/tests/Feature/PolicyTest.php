<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPolicy(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $user = User::query()->where('email', 'farhan@gmail.com')->firstOrFail();
        Auth::login($user);

        $todo = Todo::query()->first();

        self::assertTrue(Gate::allows("view", $todo));
        self::assertTrue(Gate::allows("update", $todo));
        self::assertTrue(Gate::allows("delete", $todo));
        self::assertTrue(Gate::allows("create", Todo::class));
    }

    public function testAuthorizable(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $user = User::query()->where('email', 'farhan@gmail.com')->firstOrFail();

        $todo = Todo::query()->first();

        self::assertTrue($user->can("view", $todo));
        self::assertTrue($user->can("update", $todo));
        self::assertTrue($user->can("delete", $todo));
        self::assertTrue($user->can("create", Todo::class));
    }
}
