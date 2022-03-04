<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'name' => "Richard",
                'email' => "taro@taro.com",
                'password' => Hash::make("tarotaro"),
            ],
            [
                'name' => "Mike",
                'email' => "mike@repairs.com",
                'password' => Hash::make("mike"),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}