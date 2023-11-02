<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Person;
use Tests\TestCase;

class CostumEchoHandlerTest extends TestCase
{
    public function testEcho(): void
    {
        $person = new Person();
        $person->name = "Yp";
        $person->address = "Indonesia";

        $this->view("echo", ["person" => $person])
             ->assertSeeText("Yp : Indonesia");
    }
}
