<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvTest extends TestCase
{
    
    public function testEnv(): void
    {
        $this->view('env',)->assertDontSeeText("i'm in testing development");
    }
}
