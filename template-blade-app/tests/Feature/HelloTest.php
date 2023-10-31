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
}
