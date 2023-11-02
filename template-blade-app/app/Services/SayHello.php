<?php

namespace App\Services;

class SayHello{

    function sayHello(string $name){
        return "Hello {$name}";
    }

}