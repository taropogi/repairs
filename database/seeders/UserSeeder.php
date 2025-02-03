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

        // User::factory()->times(100)->create();

        $users = [
            [
                'name' => "Richard",
                'email' => "taro@taro.com",
                'password' => Hash::make("tarotaro"),
                'is_admin' => true,
                'username' => "taro",
            ],
            [
                'name' => "Admin Tester",
                'email' => "admin@admin.com",
                'password' => Hash::make("password"),
                'is_admin' => true,
                'username' => "admin",
            ],
            [
                'name' => "Test User",
                'email' => "test@test.com",
                'password' => Hash::make("password"),
                'is_admin' => false,
                'username' => "test",
            ],
            [
                'name' => "Test User2",
                'email' => "test2@test.com",
                'password' => Hash::make("password"),
                'is_admin' => false,
                'username' => "test2",
            ]
        ];

        foreach ($users as $user) {
            $existingUser = User::where('username', $user['username'])->first();
            if ($existingUser) {
                continue;
            }
            User::create($user);
        }
    }
}
