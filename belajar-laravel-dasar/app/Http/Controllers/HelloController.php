<?php

namespace App\Http\Controllers;

use App\Services\HelloService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HelloController extends Controller
{
    private $helloService;

    public function __construct()
    {

        // Alternatif untuk membuat dependency injection pada controller
        $this->helloService = App::make(HelloService::class);

    }

    public function hello(Request $request ,string $name): string {

        return $this->helloService->hello($name);
    }


    public function request (Request $request): string {

        return  $request->path(). PHP_EOL.
                $request->url(). PHP_EOL.
                $request->fullUrl(). PHP_EOL.
                $request->method(). PHP_EOL.
                $request->header('Accept'). PHP_EOL;
    }
}
