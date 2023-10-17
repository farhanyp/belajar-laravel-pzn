<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvironmentTest extends TestCase
{
    public function testAppEnv(){

        // Memanggil APP ENV, tetapi saat melakukan pemanggilan APP ENV maka testing akan mengecek phpunit terlebih dahulu baru mengecek .env
        if(App::environment(["testing","local","prod"])){
            self::assertTrue(true);
        }
    }
}
