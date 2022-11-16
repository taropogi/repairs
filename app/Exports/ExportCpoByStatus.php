<?php

namespace App\Exports;

use App\Models\Cpo;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportCpoByStatus implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function collection()
    {
        $cpos = Cpo::select('id', 'rpo_number', 'customer_name', 'customer_address', 'contact_number', 'prepared_by', 'authorized_by')->whereIn('status_id', explode(',', $this->request->status_id))->get();
        return $cpos;
    }

    public function headings(): array
    {
        return [
            'ID',
            'RPO#',
            'Customer Name',
            'Address',
            'Contact #',
            'Prepared By',
            'Authorized By',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:G1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('DD4B39');
            },
        ];
    }
}