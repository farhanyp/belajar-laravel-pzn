<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class FormController extends Controller
{
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
}
