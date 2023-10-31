<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloTest extends TestCase
{
    public function testHello(){
        
        $this->get('/hello')->assertSeeText("Yp");
    }

    public function testViewNested(){
        
        $this->get('/world')->assertSeeText("Nested");
    }

    public function testComment(){
        
        $this->view('comment',[
            "name" => "Yp"
        ])->assertDontSeeText("Farhan");
    }

    public function testDisabledBlade(){
        
        $this->view('disabled-blade',[
            "name" => "Yp"
        ])->assertDontSeeText("Yp");
    }

    public function testIfElse(){
        
        $this->view('if-else',["hobbies" => []])->assertSeeText("i have no hobby");
        $this->view('if-else',["hobbies" => [1]])->assertSeeText("i have hobby");
        $this->view('if-else',["hobbies" => [5,2,1,3]])->assertSeeText("i have hobbies");
    }

    public function testUnless(){
        
        $this->view('unless',["isAdmin" => false])->assertSeeText("You're Not Admin",false);

        $this->view('unless',["isAdmin" => true])->assertDontSeeText("You're Not Admin");
    }

    public function testIssetEmpty(){
        
        $this->view('isset-empty',[])
             ->assertDontSeeText("Hello",false)
             ->assertSeeText("I Dont Have Hobbies",false);

        $this->view('isset-empty',["name" => "farhan"])
             ->assertSeeText("Hello, My Name is farhan",false)
             ->assertSeeText("I Dont Have Hobbies",false);

        $this->view('isset-empty',["name" => "farhan", "hobbies" => "mancing"])
             ->assertDontSeeText("I Dont Have Hobbies",false)
             ->assertSeeText("Hello, My Name is farhan",false);
    }
}
