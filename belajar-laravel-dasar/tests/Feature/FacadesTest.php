<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadesTest extends TestCase
{
    public function testConfig(){
        $firstName1 = config("contoh.name.first");

        // Contoh menggunakan Facades
        $firstName2 = Config::get("contoh.name.first");

        self::assertEquals($firstName1, $firstName2);
    }

    public function testConfigDependency(){
        // Mengakases Config::get() sama seperti dibawah ini
        $config = $this->app->make('config');
        $firstName1 = $config->get("contoh.name.first");

        $firstName2 = Config::get("contoh.name.first");

        self::assertEquals($firstName1, $firstName2);
    }

    public function testConfigMock(){

        Config::shouldReceive('get')
                ->with("contoh.name.first")
                ->andReturn("Yp Keren");

        $firstName1 = Config::get("contoh.name.first");

        self::assertEquals("Yp Keren", $firstName1);
    }
}
