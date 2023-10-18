<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DependecyInjectionTest extends TestCase
{
    public function testDependecyInjection(){

        // Contoh depedency Injection, yaitu objek yang membutuhkan objek lainnya.
        // Disini kasusnya class Bar membutuhkan Class Foo

        $foo = new Foo();
        $bar = new Bar($foo);

        self::assertEquals($bar->bar(), "Foo And Bar");
    }
}
