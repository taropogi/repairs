<?php

namespace Database\Seeders;


use App\Models\Cpo;
use App\Models\User;
use Illuminate\Database\Seeder;

class HeaderStatusHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cpos = Cpo::all();

        foreach ($cpos as $cpo) {
            $cpo->status_history()->create([
                'header_status_id' => 1,
                'changed_by' => User::all()->random()->id
            ]);
        }
    }
}