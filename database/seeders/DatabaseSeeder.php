<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create(); 
        $this->call(HeaderStatusSeeder::class);
        $this->call(UserSeeder::class);

        //for testing
        // $this->call(CpoSeeder::class);
        // $this->call(HeaderStatusHistorySeeder::class);
        // $this->call(CpoLineSeeder::class);

    }
}
