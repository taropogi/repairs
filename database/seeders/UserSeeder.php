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

        User::factory()->times(100)->create();

        $users = [
            [
                'name' => "Richard",
                'email' => "taro@taro.com",
                'password' => Hash::make("tarotaro"),
            ],
            [
                'name' => "Test User",
                'email' => "test@test.com",
                'password' => Hash::make("password"),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}