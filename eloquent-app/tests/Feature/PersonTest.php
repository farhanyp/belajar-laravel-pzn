<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
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
}
