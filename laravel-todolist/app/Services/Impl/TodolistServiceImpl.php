<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService{
    
    public function saveTodo(string $id, string $todo): void{

        Todo::query()->create([
            "id" => $id,
            "todo" => $todo,
        ]);

    }

    public function getTodolist(): array{
        return Todo::query()->get()->toArray();
    }

    public function removeTodolist(string $id){

        $todo = Todo::query()->find($id);
        if($todo != null){
            $todo->delete();
        }

        return $todo;

    }

}