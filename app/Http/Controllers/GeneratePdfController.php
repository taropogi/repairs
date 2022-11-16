<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Cpo;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Exports\ExportCpoByStatus;
use Maatwebsite\Excel\Facades\Excel;

class GeneratePdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function generatePdf(Request $request)
    {
        $cpo = Cpo::where('id', $request->id)->first();
        $data = [
            'title' => $cpo->customer_name,
            'date' => date('m/d/Y'),
            'customer_name' => strtoupper($cpo->customer_name),
            'customer_address' => strtoupper($cpo->customer_address),
            'rpo_number' => strtoupper($cpo->rpo_number),
            'contact_number' => strtoupper($cpo->contact_number),
            'prepared_by' => strtoupper($cpo->prepared_by),
            'authorized_by' => strtoupper($cpo->authorized_by),
            'lines' => $cpo->lines,
        ];

        $pdf = PDF::loadView('pdf.samplePdf', $data);

        return $pdf->download('RPO#' . $cpo->rpo_number . '.pdf');
    }

    public function listByCpoStatusPdf(Request $request)
    {
        if ($request->status_id) {


            $cpos = Cpo::whereIn('status_id', explode(',', $request->status_id))->get();


            $header_statuses = HeaderStatus::all();
            $header_statuses_indexed = [];
            foreach ($header_statuses as $status) {
                $header_statuses_indexed[$status->id] = $status->status;
            }


            $data = [
                'title' => 'CPO list by status',
                'cpos' => $cpos,
                'header_statuses' => $header_statuses_indexed,
                'date' => date('m/d/Y'),
            ];

            $pdf = PDF::loadView('pdf.cpoListByStatus', $data);



            return  $pdf->download('CPO List By Status.pdf');
        }
    }

    public function listByCpoStatusXls(Request $request)
    {

        return Excel::download(new ExportCpoByStatus($request), 'CpoListByStatus.xlsx');
    }

    public function testUser()
    {
        dd(auth()->user()->id);
    }
}