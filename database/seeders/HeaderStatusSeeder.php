<?php

namespace Database\Seeders;

use App\Models\HeaderStatus;
use Illuminate\Database\Seeder;

class HeaderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'status' => "CPOs Not Yet PRINTED"
            ],
            [
                'status' => "CPOs PRINTED but not COMPLETE"
            ],
            [
                'status' => "CPOs PRINTED, COMPLETE, NOT SUBMITTED FOR INSPECTION"
            ],
            [
                'status' => "CPOs PRINTED, COMPLETE, SUBMITTED FOR INSPECTION"
            ],
            [
                'status' => "CPOs PRINTED, COMPLETE, INSPECTED with INCOMPLETE DISPOSITION SLIPS"
            ],
            [
                'status' => "CPOs PRINTED, COMPLETE, INSPECTED with COMPLETE DISPOSITION SLIPS"
            ],

        ];

        foreach ($statuses as $status) {
            HeaderStatus::create($status);
        }
    }
}