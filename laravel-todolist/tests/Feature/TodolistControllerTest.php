<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{

    public function setUp():void{
        parent::setUp();
        DB::delete("DELETE from users");
        DB::delete("DELETE from todos");
    }
    
    public function testTodolist(): void
    {
        $this->seed([UserSeeder::class ,TodoSeeder::class]);

        $user = User::query()->first();

        $this->withSession([
            "user" => $user->email
        ])->get('/todolist')
        ->assertSeeText("todo1");
    }

    public function testAddTodolist(): void
    {
        $this->withSession([
            "user" => "farhan",
        ])->post('/todolist',[
            "id" => uniqid(),
            "todo" => "farhan"
        ])->assertRedirect("/todolist");
    }

    public function testAddTodolistFailed(): void
    {
        $this->withSession([
            "user" => "farhan",
        ])->post('/todolist',[])->assertSeeText("Todo is Required");
    }
    
    public function testRemoveTodolist(): void
    {
        $this->seed([UserSeeder::class ,TodoSeeder::class]);
        
        $this->withSession([
            "user" => "farhan@gmail.com"
        ])->post('/todolist/1/delete')
          ->assertRedirect('/todolist');
    }
}
