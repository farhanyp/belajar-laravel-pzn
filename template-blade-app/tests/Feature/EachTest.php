<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EachTest extends TestCase
{
    public function testEach(): void
    {
        $this->view('each',["users" => [
            [
                "name" => "farhan",
                "hobbies" => ["mancing", 'gaming']
            ],
            [
                "name" => "yp",
                "hobbies" => ["jalan", 'parkour']
            ]
        ]])->assertSeeInOrder([".red", "farhan", "mancing", "gaming", "yp", "jalan", "parkour"]);
    }
}
