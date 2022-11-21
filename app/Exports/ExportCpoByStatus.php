<?php

namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportCpoByStatus implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
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
        $cpos = DB::table('cpos')
            ->join('header_statuses as statuses', 'cpos.status_id', '=', 'statuses.id')
            ->select('cpos.id', 'customer_name', 'customer_address', 'contact_number', 'prepared_by', 'authorized_by', 'status')
            ->whereIn('status_id', explode(',', $this->request->status_id))
            ->get();

        return $cpos;
    }

    public function title(): string
    {
        return 'CPO List by Status';
    }



    public function headings(): array
    {
        return [

            'RPO#',
            'Customer Name',
            'Address',
            'Contact #',
            'Prepared By',
            'Authorized By',
            'Status',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $header_range = 'A1:H1';
                $event->sheet->getDelegate()->getStyle($header_range)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('007A08');

                $event->sheet->getDelegate()->getStyle($header_range)
                    ->getFont()
                    ->getColor()
                    ->setARGB('white');
            },
        ];
    }
}