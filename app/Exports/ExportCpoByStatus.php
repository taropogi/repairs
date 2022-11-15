<?php

namespace App\Exports;

use App\Models\Cpo;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCpoByStatus implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $cpos = Cpo::all();
        return $cpos;
    }
}