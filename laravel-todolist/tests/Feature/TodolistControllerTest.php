<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    
    public function testTodolist(): void
    {
        $this->withSession([
            "user" => "farhan",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "farhan"
                ]
            ]
        ])->get('/todolist')
          ->assertSeeText('1')
          ->assertSeeText("farhan");
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
        $this->withSession([
            "user" => "farhan",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "farhan"
                ]
            ]
        ])->post('/todolist/1/delete')
          ->assertRedirect('/todolist');
    }
}
