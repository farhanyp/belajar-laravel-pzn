<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LoggingTest extends TestCase
{
    public function testLogging(): void
    {
        Log::info("Hello Info");
        Log::warning("Hello Warning");
        Log::error("Hello Error");
        Log::critical("Hello Critical");

        self::assertTrue(true);
    }

    public function testContext(){

        Log::info("Hello Context", ["user" => "farhan"]);

        self::assertTrue(true);
    }

    public function testWithContext(){

        Log::withContext(["user" => "farhan"]);

        Log::info("Hello Info");
        Log::warning("Hello Warning");

        self::assertTrue(true);
    }

    public function testWithChannel(){

        $slackLogger = Log::channel('slack');
        $slackLogger->error("hello Slack"); // mengrim ke slack channel

        Log::info("Hello Info"); // mengirim ke default channel

        self::assertTrue(true);
    }

    public function testWithHandler(){

        $slackLogger = Log::channel('file');
        $slackLogger->error("hello File"); // mengrim ke slack channel

        Log::info("Hello Info"); // mengirim ke default channel

        self::assertTrue(true);
    }

    public function testJsonFormater(){

        $slackLogger = Log::channel('fileJson');
        $slackLogger->error("hello File"); // mengrim ke slack channel

        Log::info("Hello Info"); // mengirim ke default channel

        self::assertTrue(true);
    }
}


