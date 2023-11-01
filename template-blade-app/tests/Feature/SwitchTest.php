<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SwitchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSwitch(): void
    {
        $this->view('switch',[
            'value' => 'A'
        ])->assertSeeText("Memuaskan");

        $this->view('switch',[
            'value' => 'B'
        ])->assertSeeText("Baik");
    }
}
