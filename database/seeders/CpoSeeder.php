<?php

namespace Database\Seeders;

use App\Models\Cpo;
use Illuminate\Database\Seeder;

class CpoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cpo::factory()->times(1000)->create();
    }
}