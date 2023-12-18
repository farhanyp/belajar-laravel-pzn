<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testEncryption(): void
    {
        $value = "farhan";

        $encrypt = Crypt::encryptString($value);
        $decrypt = Crypt::decryptString($encrypt);

        self::assertEquals($value, $decrypt);
    }
}
