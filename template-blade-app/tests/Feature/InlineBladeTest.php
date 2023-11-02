<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class InlineBladeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInlineBladeTemplate(): void
    {
        $response = Blade::render('Hello {{$name}}', ['name' => "farhan"]);

        self::assertEquals("Hello farhan", $response);
    }
}
