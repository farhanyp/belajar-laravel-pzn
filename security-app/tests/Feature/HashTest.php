<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HashTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testHash(): void
    {
        $password1 = "rahasia";
        $hash = Hash::make($password1);

        $result = Hash::check($password1, $hash);

        self::assertTrue($result);
    }
}
