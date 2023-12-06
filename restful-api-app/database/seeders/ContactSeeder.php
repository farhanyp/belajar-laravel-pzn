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
        $user = User::query()->where("username", "test")->first();

        Contact::query()->create([
            "first_name" => "tes1",
            "last_name" => "tes1",
            "email" => "tes1@gmail.com",
            "phone" => "123456",
            "user_id" => $user->id
        ]);
    }
}
