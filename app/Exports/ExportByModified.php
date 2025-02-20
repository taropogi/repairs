<?php

namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportByModified implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
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
        $qry =  DB::table('cpos')
            // ->join('header_statuses as statuses', 'cpos.status_id', '=', 'statuses.id')
            ->select('cpos.id', 'rma_number', 'customer_reference_number', 'customer_name', 'customer_address', 'updated_at')
            ->whereRaw(DB::raw("Date(cpos.updated_at) <= '" . $this->request->cpo_modified_to . "'"))
            ->whereRaw(DB::raw("Date(cpos.updated_at) >= '" . $this->request->cpo_modified_from . "'"))
            ->whereRaw(DB::raw('cpos.updated_at <> cpos.created_at'))
            ->where('deleted_at', null);


        if (!auth()->user()->canAccessOtherCpos()) {
            $qry = $qry->where('created_by', auth()->user()->id);
        }

        $cpos = $qry->get();

        $cpos->transform(function ($item) {
            $item->id =  str_pad($item->id, config('global.cpoNumberPadZero'), '0', STR_PAD_LEFT);
            $item->rma_number =  $item->rma_number ? str_pad($item->rma_number, config('global.rmaNumberPadZero'), '0', STR_PAD_LEFT)   : 'N/A';
            return $item;
        });

        // ->whereRaw(DB::raw("Date(updated_at) <= '" . $request->cpo_modified_to . "'"))
        // ->whereRaw(DB::raw('updated_at <> created_at'))

        return $cpos;
    }



    public function headings(): array
    {
        return [

            'RPO#',
            'RMA#',
            'REF#',
            'CUSTOMER NAME',
            'ADDRESS',
            'MODIFIED AT',

        ];
    }


    public function title(): string
    {
        return 'CPOs Modified List';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $header_range = 'A1:F1';
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
