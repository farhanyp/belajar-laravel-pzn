<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    
    public function testStorage()
    {
        $fileSystem = Storage::disk("local");
        $fileSystem->put("file.txt", "Farhan Yudha Pratama");

        self::assertEquals("Farhan Yudha Pratama", $fileSystem->get("file.txt"));
    }
}
