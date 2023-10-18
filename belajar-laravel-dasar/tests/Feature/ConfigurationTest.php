<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testGetConfig(){

        // mengambil config contoh dari folder config/contoh.php
        $first_name = config("contoh.name.first");
        $last_name = config("contoh.name.last");
        $web = config("contoh.web");
        $address = config("contoh.address","Tidak ada address");

        self::assertEquals($first_name, "farhan");
        self::assertEquals($last_name, "yp");
        self::assertEquals($web, "INIWEB");
        self::assertEquals($address, "Tidak ada address");
    }
}
