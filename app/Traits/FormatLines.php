<?php

namespace App\Traits;

use App\Models\CpoLine;


trait FormatLines
{


    public function sortLineNumbers($cpo_id)
    {
        $lines = CpoLine::where('cpo_id', $cpo_id)->orderBy('created_at', 'ASC')->get();
        $line_number = 1;
        foreach ($lines as $line) {
            $line->line_number = $line_number;
            $line->update();
            $line_number++;
        }
    }
}