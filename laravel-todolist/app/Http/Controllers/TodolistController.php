<?php

namespace App\Http\Controllers;

use App\Services\Impl\TodolistServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class TodolistController extends Controller
{
    private $todolist; 

    public function __construct()
    {
        $this->todolist = App::make(TodolistServiceImpl::class);
    }

    public function todolist(){

        $todolist = $this->todolist->getTodolist();

        return view('user.todolist',[
            "title" => "Todolist",
            "todolist" => $todolist
        ]);
    }

    public function addTodo(Request $request){
        
        $todo = $request->input('todo');
        $todolist = $this->todolist->getTodolist();

        if(empty($todo)){
            return view('user.todolist',[
                "title" => "Todolist",
                "todolist" => $todolist,
                "error" => "Todo is Required"
            ]);
        };

        $this->todolist->saveTodo(uniqid(), $todo);
        return redirect()->action([TodolistController::class, "todolist"]);
    }

    public function removeTodo(string $id){
        
        $this->todolist->removeTodolist($id);

        return redirect()->action([TodolistController::class, "todolist"]);
    }
}
