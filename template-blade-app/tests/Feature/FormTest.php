<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    public function testForm(): void
    {
        $this->view('form', ["user" => [
            "premium" => true,
            "name" => "Yp",
            "admin" => true
        ]])->assertSee("checked")->assertSee("Yp")->assertDontSee("readonly");
    }
}
