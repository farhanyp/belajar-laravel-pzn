<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TodoControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testController(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $this->post('/api/todo')->assertStatus(403);

        $users = User::where('email', 'farhan@gmail.com')->firstOrFail();

        $this->actingAs($users)->post('/api/todo')->assertStatus(200);

    }

    public function testView(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);
        $users = User::where('email', 'farhan@gmail.com')->firstOrFail();
        Auth::login($users);
        
        $todos = Todo::query()->get();

        $this->view("todos", [
            "todos" => $todos
        ])->assertSeeText("edit")
          ->assertDontSeeText("no edit");

    }
}
