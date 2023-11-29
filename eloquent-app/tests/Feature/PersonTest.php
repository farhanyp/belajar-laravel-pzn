<?php

namespace Tests\Feature;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    
    public function testPerson(): void
    {
        $person = new Person();
        $person->first_name = "farhan";
        $person->last_name = "yudha";
        $person->save();

        self::assertEquals("farhan yudha", $person->fullName);

        $person->full_name = "yp yp";
        $person->save();

        self::assertEquals("yp",  $person->first_name);
        self::assertEquals("yp",  $person->last_name);
    }

    public function testAttributeCasting(): void
    {
        $person = new Person();
        $person->first_name = "farhan";
        $person->last_name = "yudha";
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }
}
