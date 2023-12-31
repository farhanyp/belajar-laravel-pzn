<?php

namespace Tests\Feature;

use App\Rules\RegistrationRule;
use App\Rules\Uppercase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
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

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorValidationException(): void
    {
        $data = [
            "username" => "",
            "password" => "12345",
        ];

        $rules = [
            "username" => "required",
            "password" => "required",
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try{
            // berfungsi untuk cek validasi, jika ada error akan masuk ke exception, jika tidak ada akan lanjut
            $validator->validate();
            self::fail("Tidak ada Validation");
        }catch(ValidationException $exception){
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorMultiperRules(): void
    {
        $data = [
            "username" => "admin",
            "password" => "12345",
        ];

        $rules = [
            "username" => ["required", "email", "max:100"],
            "password" => ["required", "min:6", "max:20"]
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        self::assertTrue($validator->fails());
        Log::info($validator->errors()->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorValidData(): void
    {
        $data = [
            "username" => "admin@gmail.com",
            "password" => "12345678",
            "admin" => true
        ];

        $rules = [
            "username" => ["required", "email", "max:100"],
            "password" => ["required", "min:6", "max:20"]
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try{
            $valid = $validator->validate();
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));

        }catch(ValidationException $exception){
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorValidationMessageWithEn(): void
    {
        $data = [
            "username" => "admin",
            "password" => "12345678",
            "admin" => true
        ];

        $rules = [
            "username" => ["required", "email", "max:100"],
            "password" => ["required", "min:6", "max:20"]
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try{
            $valid = $validator->validate();
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));

        }catch(ValidationException $exception){
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorValidationMessageWithLocalizationId(): void
    {
        App::setLocale("id");
        $data = [
            "username" => "admin",
            "password" => "12345678",
            "admin" => true
        ];

        $rules = [
            "username" => ["required", "email", "max:100"],
            "password" => ["required", "min:6", "max:20"]
        ];

        $validator = Validator::make($data, $rules);
        self::assertNotNull($validator);

        try{
            $valid = $validator->validate();
            Log::info(json_encode($valid, JSON_PRETTY_PRINT));

        }catch(ValidationException $exception){
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidatorCustomRule(): void
    {
        $data = [
            "username" => "admin123@gmail.com",
            "password" => "admin123@gmail.com",
        ];

        $rules = [
            "username" => ["required", "email", "max:100", new Uppercase()],
            "password" => ["required", "min:6", "max:20", new RegistrationRule()]
        ];

        $validator = Validator::make($data, $rules);

        self::assertNotNull($validator);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidatorCustomFunctionRule(): void
    {
        $data = [
            "username" => "admin",
            "password" => "12345678",
            "admin" => true
        ];

        $rules = [
            "username" => ["required", "email", "max:100", function(string $attribute, string $value, \Closure $fail){
                if(strtoupper($value) != $value){
                    $fail("The field $attribute must be UPPERCASE");
                }
            }],
            "password" => ["required", "min:6", "max:20"]
        ];

        $validator = Validator::make($data, $rules);

        self::assertNotNull($validator);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }


    public function testValidatorRuleClasses(): void
    {
        $data = [
            "username" => "farhan",
            "password" => "12345678",
        ];

        $rules = [
            "username" => ["required", "email", "max:100", new In(["farhan", "yudha"])],
            "password" => ["required", "max:20", Password::min(6)]
        ];

        $validator = Validator::make($data, $rules);

        self::assertNotNull($validator);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testNestedArray(): void
    {
        $data = [
            "name" => [
                "first" => "farhan",
                "last" => "yudha",
            ],
            "address" => [
                [
                    "street" => "Jalan. GG",
                    "city" => "Medan"
                ],
                [
                    "street" => "Jalan. GG",
                    "city" => "Medan"
                ],
            ]
        ];

        $rules = [
            "name.first" => ["required", "max:100"],
            "name.last" => ["max:100"],
            "address.*.street" => ["max:100"],
            "address.*.city" => ["max:100"],
        ];

        $validator = Validator::make($data, $rules);

        self::assertNotNull($validator);
        self::assertTrue($validator->passes());
        self::assertFalse($validator->fails());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }
}
