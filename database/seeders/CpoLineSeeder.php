<?php

namespace Database\Seeders;

use App\Models\CpoLines;
use Illuminate\Database\Seeder;

class CpoLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CpoLInes::factory()->times(500)->create();
    }
}