<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class GateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGate(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::query()->where("email", "farhan@gmail.com")->firstOrFail();
        Auth::login($user);

        $contact = Contact::query()->where("email", "test@gmail.com")->firstOrFail();

        self::assertTrue(Gate::allows("get-contact", $contact));
        self::assertTrue(Gate::allows("update-contact", $contact));
        self::assertTrue(Gate::allows("delete-contact", $contact));
    }
}
