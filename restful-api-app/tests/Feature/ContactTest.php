<?php

namespace Tests\Feature;

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\SearchSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateSuccess(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post("/api/contacts",[
            "first_name" => "farhan",
            "last_name" => "yp",
            "email" => "yp@gmail.com",
            "phone" => "123456",
        ],[
            'Authorization' => 'test'
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "first_name" => "farhan",
                    "last_name" => "yp",
                    "email" => "yp@gmail.com",
                    "phone" => "123456",
                ]
            ]);
    }

    public function testCreateFailed(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post("/api/contacts",[
            "first_name" => "",
            "last_name" => "yp",
            "email" => "",
            "phone" => "123456",
        ],[
            'Authorization' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "first_name"=> [
                        "The first name field is required."
                    ]
                ]
            ]);
    }

    public function testCreateUnauthorized(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post("/api/contacts",[
            "first_name" => "",
            "last_name" => "yp",
            "email" => "",
            "phone" => "123456",
        ],[
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message"=> [
                        "unauthorized"
                    ]
                ]
            ]);
    }

    public function testGetSuccess(){
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->get("/api/contacts/".$contact->id,[
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "first_name" => "tes1",
                    "last_name" => "tes1",
                    "email" => "tes1@gmail.com",
                    "phone" => "123456",
                ]
            ]);
    }

    public function testGetNotFound(){
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->get("/api/contacts/".$contact->id+1,[
            'Authorization' => 'test'
        ])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "Not Found"
                    ]
                ]
            ]); 
    }

    public function testCantGetFromOtherUser(){

        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->get("/api/contacts/".$contact->id+1,[
            'Authorization' => 'test2'
        ])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "Not Found"
                    ]
                ]
            ]);
    }

    public function testUpdateSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->put("/api/contacts/".$contact->id,
        [
            "first_name" => "tes2",
            "last_name" => "tes2",
            "email" => "tes2@gmail.com",
            "phone" => "123456",
        ],
        [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "first_name" => "tes2",
                    "last_name" => "tes2",
                    "email" => "tes2@gmail.com",
                    "phone" => "123456",
                ]
            ]);
    }

    public function testUpdateValidationError(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->put("/api/contacts/".$contact->id,
        [
            "first_name" => "",
            "last_name" => "tes2",
            "email" => "tes2@gmail.com",
            "phone" => "123456",
        ],
        [
            'Authorization' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "first_name"=> [
                        "The first name field is required."
                    ]
                ]
            ]);
    }

    public function testDeleteSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->delete("/api/contacts/".$contact->id,[],
        [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                "data" => true
            ]);
    }

    public function testDeleteFailedIfForAnotherUser(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->delete("/api/contacts/".$contact->id,[],
        [
            'Authorization' => 'test2'
        ])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "Not Found"
                    ]
                ]
            ]);
    }

    public function testSearchByFirstName(){

        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/api/contacts?name=first', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']["total"]);

    }

    public function testSearchByLastName(){

        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/api/contacts?name=last', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']["total"]);

    }

    public function testSearchByEmail(){

        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/api/contacts?email=test', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']["total"]);

    }

    public function testSearchByPhone(){

        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/api/contacts?phone=11111', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']["total"]);

    }

    public function testSearchByNothing(){

        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/api/contacts?name=kosong', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        self::assertEquals(0, count($response['data']));
        self::assertEquals(0, $response['meta']["total"]);

    }

    public function testSearchWithPage(){

        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/api/contacts?size=5&page=2', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        self::assertEquals(5, count($response['data']));
        self::assertEquals(20, $response['meta']["total"]);
        self::assertEquals(2, $response['meta']["current_page"]);

    }
}
