<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ExportCpoLists implements WithMultipleSheets
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];


        $sheets[] = new ExportCpoByStatus($this->request);
        $sheets[] = new ExportByModified($this->request);
        $sheets[] = new ExportByChangedStatus($this->request);


        return $sheets;
    }
}
