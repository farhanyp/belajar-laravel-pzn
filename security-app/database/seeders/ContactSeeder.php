<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'farhan@gmail.com')->first();

        $contact = new Contact();
        $contact->name = "Test Contact";
        $contact->email = "test@gmail.com";
        $contact->user_id = $user->id;
        $contact->save();
    }
}
