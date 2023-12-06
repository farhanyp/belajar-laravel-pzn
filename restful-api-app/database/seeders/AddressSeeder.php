<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $contact = Contact::query()->first();

        Address::query()->create([
            "contact_id" => $contact->id,
            "street" => "test",
            "city" => "test",
            "province" => "test",
            "country" => "test",
            "postal_code" => "test",
        ]);
    }
}
