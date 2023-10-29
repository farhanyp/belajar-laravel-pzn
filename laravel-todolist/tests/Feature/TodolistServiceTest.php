<?php

namespace Tests\Feature;

use App\Services\Impl\TodolistServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistServiceImpl $todolistService;

    protected function setUp():void {

        parent::setUp();

        $this->todolistService = $this->app->make(TodolistServiceImpl::class);
    }

    public function testTodolistService(): void
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodolist(): void
    {
        $this->todolistService->saveTodo('1', 'farhan');

        $todolist = Session::get('todolist');

        foreach($todolist as $value){
            self::assertEquals('1', $value["id"]);
            self::assertEquals('farhan', $value['todo']);
        }
    }

    public function testGetTodolistEmpty(): void
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty(): void
    {
        $expected= [
            [
                "id" => "1",
                "todo" => "farhan",
            ],
            [
                "id" => "2",
                "todo" => "yp",
            ]
        ];

        $this->todolistService->saveTodo('1', 'farhan');
        $this->todolistService->saveTodo('2', 'yp');


        self::assertEquals($expected, $this->todolistService->getTodolist());
    }

    public function testRemoveTodolist(): void
    {

        $this->todolistService->saveTodo('1', 'farhan');
        $this->todolistService->saveTodo('2', 'yp');

        $this->todolistService->removeTodolist('3');
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodolist('2');
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodolist('1');
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
