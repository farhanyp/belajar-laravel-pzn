<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoopVariableTest extends TestCase
{
    public function testLoopVariable(): void
    {
        $this->view('loop-variable', ["hobbies" => ["Memancing"]])->assertSeeText("1. Memancing");
    }
}
