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

        self::assertTrue(Gate::any(["get-contact", "update-contact", "delete-contact"], $contact));
        self::assertFalse(Gate::none(["get-contact", "update-contact", "delete-contact"], $contact));
    }

    public function testGateNonLogin(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::query()->where("email", "farhan@gmail.com")->firstOrFail();
        $gate = Gate::forUser($user);

        $contact = Contact::query()->where("email", "test@gmail.com")->firstOrFail();

        self::assertTrue($gate->allows("get-contact", $contact));
        self::assertTrue($gate->allows("update-contact", $contact));
        self::assertTrue($gate->allows("delete-contact", $contact));
    }

    public function testGateResponse(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::query()->where("email", "farhan@gmail.com")->firstOrFail();
        Auth::login($user);

        $response = Gate::inspect("create-contact");

        self::assertFalse($response->allowed());
        self::assertEquals("you're not admin", $response->message());
    }
}
