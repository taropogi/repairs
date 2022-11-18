<?php

namespace Database\Seeders;

use App\Models\CpoLine;
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
        CpoLIne::factory()->times(1000)->create();
    }
}