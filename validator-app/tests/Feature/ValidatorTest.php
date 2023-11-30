<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    
    public function testValidatorValid(): void
    {
        $data = [
            "username" => "admin",
            "password" => "123456",
        ];

        $rules = [
            "username" => "required",
            "password" => "required",
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());
    }

    public function testValidatorInvalid(): void
    {
        $data = [
            "username" => "",
            "password" => "123456",
        ];

        $rules = [
            "username" => "required",
            "password" => "required",
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertFalse($validator->passes());;
        self::assertTrue($validator->fails());
    }
}
