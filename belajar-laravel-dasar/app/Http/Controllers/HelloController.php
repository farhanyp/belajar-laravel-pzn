<?php

namespace App\Http\Controllers;

use App\Services\HelloService;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    private HelloService $HelloService;

    public function __construct(HelloService $HelloService)
    {
        
        $this->HelloService = $HelloService;

    }

    public function hello (string $name): string {

        return $this->HelloService->hello($name);

    }
}
