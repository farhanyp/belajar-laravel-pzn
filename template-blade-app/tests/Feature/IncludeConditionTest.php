<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeConditionTest extends TestCase
{
    public function testIncludeCondition(): void
    {
        $this->view('include-condition',['user' =>[
            "name" => "farhan",
            "owner" => false,
        ]])
             ->assertSeeText("Selamat Datang farhan")
             ->assertDontSeeText("Selamat Datang Owner");
    }

    public function testIncludeConditionWithOwner(): void
    {
        $this->view('include-condition',['user' =>[
            "name" => "farhan",
            "owner" => true,
        ]])
             ->assertSeeText("Selamat Datang farhan")
             ->assertSeeText("Selamat Datang Owner");
    }
}
