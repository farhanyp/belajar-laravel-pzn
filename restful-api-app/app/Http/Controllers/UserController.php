<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse{

        $request->validated();

        $data = $request->all();

        if(User::query()->where('username', $data["username"])->count() == 1){
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "username already registered"
                    ]
                ]
            ], 400));
        }

        // cara 1
        $user = new User($data);
        $user->save();

        // cara 2
        // $user = User::query()->create($data);

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $request): UserResource{

        $request->validated();

        $data = $request->all();

        $user = User::query()->where("username", $data["username"])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            throw new HttpResponseException(response([
                "errors" =>[
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ]));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    public function get(Request $request): UserResource {

        $user = Auth::user();

        return new UserResource($user);
    }

    public function update (UserUpdateRequest $request): UserResource {
        
        $data = $request->validated();
        $user = Auth::user();
        $newUser = User::query()->find($user->id);

        if(isset($data["name"])){
            $newUser->name = $data["name"];
        }

        if(isset($data["password"])){
            $newUser->password = $data["password"];
        }

        $newUser->save();
        return new UserResource($newUser);
    }

    public function logout (Request $request): JsonResponse {
        
        $user = Auth::user();
        $newUser = User::query()->find($user->id);
        $newUser->token = null;
        $newUser->save();

        return response()->json([
            "data" => true
        ]);
    }
}
