<?php

namespace App\Data;

class Bar{

    // Contoh depedency Injection, yaitu objek yang membutuhkan objek lainnya.
    // Disini kasusnya class Bar membutuhkan Class Foo
    private Foo $foo;

    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }

    public function bar(){
        return $this->foo->foo()." And Bar";
    }
}