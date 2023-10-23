<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{

    public function testEncrypt()
    {
        $encrypt = Crypt::encrypt('Farhan Yudha Pratama');

        $decrypt = Crypt::decrypt($encrypt);

        self::assertEquals("Farhan Yudha Pratama", $decrypt);
    }
}
