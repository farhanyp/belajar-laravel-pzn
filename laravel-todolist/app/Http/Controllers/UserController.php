<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = App::make(UserService::class);
    }

    public function login(): Response{
        return response()->view('user.login', [
            "title" => "Login"
        ]);
    } 

    public function doLogin(Request $request): Response|RedirectResponse{
        $user = $request->input('user');
        $password = $request->input('password');

        if(empty($user) || empty($password)){
            return response()->view('user.login',[
                'title' => "Login",
                'error' => "User or password is empty"
            ]);
        }

        if($this->userService->login($user,$password)){
            $request->session()->put("user", $user);
            return redirect('/');
        };

        return response()->view("user.login", [
            "title" => "Login",
            "error" => "User or password is wrong",
        ]);
    }

    public function doLogout(Request $request){
        $request->session()->forget("user");
        return redirect('/');
    }
}   
