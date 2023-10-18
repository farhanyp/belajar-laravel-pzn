<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    
    public function testCreateDependencyWithoutConstructor()
    {
        
        $foo1 = $this->app->make(Foo::class); // sama saja seperti membuat objek seperti ini, new Foo()
        $foo2 = $this->app->make(Foo::class); // sama saja seperti membuat objek seperti ini, new Bar()

        self::assertEquals("Foo", $foo1->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo1, $foo2); // Walaupun foo1 dan foo2 sama sama memanggil class yang sama, tetapi berbeda

    }

    public function testCreateDependencyWithConstructor()
    {
        // Object Person akan selalu dipanggil jika memakai bind
        $this->app->bind(Person::class, function($app){
            return new Person("Farhan", "Yudha");
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertNotSame($person1, $person2); 
    }

    public function testSingleton()
    {
        // Object Person akan dipanggil sekali jika memakai singleton
        $this->app->singleton(Person::class, function($app){
            return new Person("Farhan", "Yudha");
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertSame($person1, $person2); 
    }

    public function testInstance()
    {
        // Jika memakai instance maka setiap pemanggilan object person, maka akan menggunakan object yang sudah ada
        $person = new Person("Farhan", "Yudha");
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertSame($person1, $person2); 
    }

    public function testDependencyInjection()
    {
        // Pada laravel jika Bar membutuhkan constructor dari Foo dan Foo juga sudah dimasukan kedalam Service Container, maka laravel otomatis menambahkan Foo kedalam Bar
        $this->app->singleton(Foo::class, function($app){
            return new Foo();
        });

        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        self::assertEquals("Foo And Bar", $bar->bar()); 
    }

    public function testDependencyInjectionInClosure()
    {
        $this->app->singleton(Foo::class, function($app){
            return new Foo();
        });

        $this->app->singleton(Bar::class, function($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($bar1, $bar2); 
    }

    public function testHelloService (){

        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals("Hello Yp", $helloService->hello("Yp"));
    }
}
