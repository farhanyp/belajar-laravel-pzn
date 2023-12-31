<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=yp')->assertSeeText("Hello yp");

        $this->post('/input/hello',["name" => "yp"])->assertSeeText("Hello yp");
    }

    public function testNestedInput()
    {

        $this->post('/input/hello/first',
        ["name" => [
            "first" => "yp"
        ]])->assertSeeText("Hello yp");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input',
        ["name" => [
            "first" => "farhan",
            "last" => "yp"
        ]])->assertSeeText("name")->assertSeeText("first")->assertSeeText("last");
    }

    public function testArrayInput()
    {
        $this->post('/input/hello/array',[
            "products" => [
                ["name" => "farhan",],
                ["name" => "yp"]
            ]
        ]
        )->assertSeeText("farhan")->assertSeeText("yp");
    }

    public function testInputType()
    {
        $this->post('/input/type',[
            "name" => "farhan",
            "married" => "true",
            "birth_date" => "2023-10-23",
        ]
        )->assertSeeText("farhan")->assertSeeText(true)->assertSeeText("2023-10-23");
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only',[
            "name" => [
                "first" => "Farhan",
                "middle" => "Yudha",
                "last" => "Pratama"
            ]
        ]
        )->assertSeeText("Farhan")->assertDontSee("Yudha")->assertSeeText("Pratama");
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except',[
            "name" => [
                "first" => "Farhan",
                "middle" => "Yudha",
                "last" => "Pratama"
            ]
        ]
        )->assertDontSee("Farhan")->assertSeeText("Yudha")->assertDontSee("Pratama");
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/except',[
            "admin" => true
        ]
        )->assertSeeText("admin")->assertSeeText(false);
    }
}
