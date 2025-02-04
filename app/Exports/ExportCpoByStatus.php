<?php

namespace App\Exports;


use App\Models\Cpo;
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

        $qry = DB::table('cpos')
            ->join('header_statuses as statuses', 'cpos.status_id', '=', 'statuses.id')
            ->select('cpos.id', 'customer_reference_number', 'customer_name', 'customer_address', 'contact_number', 'prepared_by', 'authorized_by', 'status')
            ->whereIn('status_id', explode(',', $this->request->status_id))
            ->where('deleted_at', null);

        if (!auth()->user()->canAccessOtherCpos()) {
            $qry = $qry->where('created_by', auth()->user()->id);
        }

        $cpos = $qry->get();



        $cpos = $cpos->map(function ($item) {
            $item->id =  str_pad($item->id, 5, '0', STR_PAD_LEFT);
            return $item;
        });

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
            'REF#',
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
