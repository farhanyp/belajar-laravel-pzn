<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FormController extends Controller
{
    public function form(): Response{
        return response()->view("form");
    }


    public function login (Request $request): Response{
        try {
            $request->validate([
                "username" => "required",
                "password" => "required",
            ]);
            
            return response("OK", Response::HTTP_OK);
        } catch (ValidationException $exception) {
            return response($exception->errors(), Response::HTTP_BAD_REQUEST);
        }
    }


    public function submitForm (LoginRequest $request): Response{
            $request->validated();
            $data = $request->all();
            Log::info($data);
            return response("OK", Response::HTTP_OK);
    }
}
