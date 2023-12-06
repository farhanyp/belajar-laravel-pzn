<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Database\Seeders\AddressSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    
    public function testCreateSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->post('/api/contacts/'.$contact->id.'/addresses',
        [
            "street" => "tes",
            "city" => "tes",
            "province" => "tes",
            "country" => "tes",
            "postal_code" => "tes",
        ],
        [
            'Authorization' => 'test'
        ])
             ->assertStatus(201)
             ->assertJson([
                "data" => [
                    "street" => "tes",
                    "city" => "tes",
                    "province" => "tes",
                    "country" => "tes",
                    "postal_code" => "tes",
                ]
            ]);
    }

    public function testCreateFailed(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->post('/api/contacts/'.$contact->id.'/addresses',
        [
            "street" => "tes",
            "city" => "tes",
            "province" => "tes",
            "country" => "",
            "postal_code" => "tes",
        ],
        [
            'Authorization' => 'test'
        ])
             ->assertStatus(400)
             ->assertJson([
                "errors" => [
                    "country" => [
                        "The country field is required."
                    ],
                ]
             ]);
    }

    public function testCreateWithDifferentContactId(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->first();

        $this->post('/api/contacts/'. ($contact->id+1) .'/addresses',
        [
            "street" => "tes",
            "city" => "tes",
            "province" => "tes",
            "country" => "tes",
            "postal_code" => "tes",
        ],
        [
            'Authorization' => 'test'
        ])
             ->assertStatus(404)
             ->assertJson([
                "errors" => [
                    "message" => [
                        "Not Found"
                    ],
                ]
             ]);
    }

    public function testGetAddressSuccess(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->get("/api/contacts/".$contact->id."/addresses/".$address->id,[
            'Authorization' => 'test'
        ])
            ->assertStatus(200)
            ->assertJson([
                "data" =>[
                    "street" => "test",
                    "city" => "test",
                    "province" => "test",
                    "country" => "test",
                    "postal_code" => "test",
                ]
            ]);
    }

    public function testGetAddressFailed(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->get("/api/contacts/".$contact->id."/addresses/".$address->id,[
        ])
            ->assertStatus(401)
            ->assertJson([
                "errors" =>[
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ]);
    }

    public function testGetAddressNotFound(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->get("/api/contacts/".$contact->id."/addresses/".($address->id+1),[
            'Authorization' => 'test'
        ])
            ->assertStatus(404)
            ->assertJson([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ]
                ]
            ]);
    }

    public function testUpdateAddressSuccess(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->put("/api/contacts/".$contact->id."/addresses/".$address->id,
        [
            "street" => "update",
            "city" => "update",
            "province" => "update",
            "country" => "update",
            "postal_code" => "update",
        ],
        [
            'Authorization' => 'test'
        ])
            ->assertStatus(200)
            ->assertJson([
                "data" =>[
                    "street" => "update",
                    "city" => "update",
                    "province" => "update",
                    "country" => "update",
                    "postal_code" => "update",
                ]
            ]);
    }

    public function testUpdateAddressUnauthorized(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->put("/api/contacts/".$contact->id."/addresses/".$address->id,
        [
            "street" => "update",
            "city" => "update",
            "province" => "update",
            "country" => "update",
            "postal_code" => "update",
        ],
        [
        ])
            ->assertStatus(401)
            ->assertJson([
                "errors" =>[
                    "message" => [
                        "unauthorized"
                    ],
                ]
            ]);
    }

    public function testRemoveAddressSuccess(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->delete("/api/contacts/".$contact->id."/addresses/".$address->id,[],
        [
            'Authorization' => 'test'
        ])
            ->assertStatus(200)
            ->assertJson([
                "data" =>true
            ]);
    }

    public function testRemoveAddressUnauthorized(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->delete("/api/contacts/".$contact->id."/addresses/".$address->id,[],
        [
        ])
            ->assertStatus(401)
            ->assertJson([
                "errors" =>[
                    "message" => [
                        "unauthorized"
                    ],
                ]
            ]);
    }

    public function testGetListAddressSuccess(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->get("/api/contacts/".$contact->id."/addresses",[
            'Authorization' => 'test'
        ])
            ->assertStatus(200)
            ->assertJson([
                "data" =>[
                    [
                        "street" => "test",
                        "city" => "test",
                        "province" => "test",
                        "country" => "test",
                        "postal_code" => "test",
                    ]
                ]
            ]);
    }

    public function testGetListAddressUnauthorized(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->get("/api/contacts/".$contact->id."/addresses",[
        ])
            ->assertStatus(401)
            ->assertJson([
                "errors" =>[
                    "message" => [
                        "unauthorized"
                    ],
                ]
            ]);
    }

    public function testGetListAddressNotFound(){
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->first();
        $address = Address::query()->first();

        $this->get("/api/contacts/".($contact->id + 1)."/addresses",[
            'Authorization' => 'test'
        ])
            ->assertStatus(404)
            ->assertJson([
                "errors" =>[
                    "message" => [
                        "Not Found"
                    ],
                ]
            ]);
    }
}
