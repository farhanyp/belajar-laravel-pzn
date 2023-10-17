<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetEnv()
    {
        $env = env("Author");

        self::assertEquals($env, "maman");
    }

    public function defaultEnv(){
        
        $env = env("YOUTUBE", "maman");

        self::assertEquals($env, "maman");
    }
}
