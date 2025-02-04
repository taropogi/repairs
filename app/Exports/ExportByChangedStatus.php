<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportByChangedStatus implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
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
        // $cpos = DB::table('cpos')
        //     // ->join('header_statuses as statuses', 'cpos.status_id', '=', 'statuses.id')
        //     ->select('cpos.id', 'rpo_number', 'customer_name', 'customer_address', 'updated_at')
        //     ->whereRaw(DB::raw("Date(cpos.updated_at) <= '" . $this->request->cpo_modified_to . "'"))
        //     ->whereRaw(DB::raw("Date(cpos.updated_at) >= '" . $this->request->cpo_modified_from . "'"))
        //     ->whereRaw(DB::raw('cpos.updated_at <> cpos.created_at'))
        //     ->get();


        $query = DB::table('header_status_histories as history')
            ->join('cpos', 'cpos.id', '=', 'history.cpo_id')
            ->join('header_statuses as status_to', 'status_to.id', '=', 'history.header_status_id')
            ->join('header_statuses as status_from', 'status_from.id', '=', 'history.old_status_id')
            ->select('cpos.id', 'cpos.customer_reference_number', 'status_to.status as status_new', 'status_from.status as status_old')
            ->selectRaw('date(history.updated_at) as changed_date')
            ->whereRaw("Date(history.updated_at) >= '" . $this->request->cpo_changed_date_from . "'")
            ->whereRaw("Date(history.updated_at) <= '" . $this->request->cpo_changed_date_to . "'")
            ->whereRaw("history.old_status_id is not null")
            ->where("history.header_status_id", $this->request->cpo_changed_status_to)
            ->where('cpos.deleted_at', null);

        if ($this->request->cpo_changed_current_only && ($this->request->cpo_changed_current_only === 'true')) {
            $query->where("cpos.status_id", $this->request->cpo_changed_status_to);
        }

        if (!auth()->user()->canAccessOtherCpos()) {
            $query = $query->where('created_by', auth()->user()->id);
        }


        $cpos = $query->get();

        $cpos = $cpos->map(function ($item) {
            $item->id = str_pad($item->id, 5, '0', STR_PAD_LEFT);
            return $item;
        });



        return $cpos;
    }

    public function headings(): array
    {
        return [

            'RPO#',
            'REF#',
            'Status From',
            'Status To',
            'Date',

        ];
    }

    public function title(): string
    {
        return 'CPOs Changed Status';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $header_range = 'A1:E1';
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
