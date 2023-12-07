<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use App\Services\Impl\TodolistServiceImpl;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistServiceImpl $todolistService;

    protected function setUp():void {

        parent::setUp();
        DB::delete("DELETE FROM todos");
        DB::delete("DELETE FROM users");
        $this->todolistService = $this->app->make(TodolistServiceImpl::class);
    }

    public function testTodolistService(): void
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodolist(): void
    {
        $this->todolistService->saveTodo('1', 'todo1');

        $todolist = $this->todolistService->getTodolist();

        foreach($todolist as $value){
            self::assertEquals('1', $value["id"]);
            self::assertEquals('todo1', $value['todo']);
        }
    }

    public function testGetTodolistEmpty(): void
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty(): void
    {
        $this->seed([TodoSeeder::class]);
        $expected= [
            [
                "id" => "1",
                "todo" => "todo1",
            ],
            [
                "id" => "2",
                "todo" => "todo2",
            ]
        ];

        Assert::assertArraySubset($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodolist(): void
    {
        $this->seed([TodoSeeder::class]);
        
        $this->todolistService->removeTodolist('2');
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodolist('1');
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
