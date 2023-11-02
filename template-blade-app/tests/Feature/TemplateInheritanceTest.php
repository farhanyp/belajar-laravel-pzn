<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TemplateInheritanceTest extends TestCase
{
    public function testTemplateInherintance(): void
    {
        $this->view('child',[])
             ->assertSeeText("Nama Aplikasi - Halaman Utama")
             ->assertSeeText("Deskripsi Header");
    }

    public function testTemplateInherintanceWithShow(): void
    {
        $this->view('child-show',[])
             ->assertSeeText("Nama Aplikasi - Halaman Utama")
             ->assertSeeText("Default Header");
    }
}
