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
        $cpo = Cpo::where('id', $request->id)->get();
        $data['title'] = 'Multi Selected CPOS';
        $data['cpos'] = $cpo;
        $data['date'] = date('m/d/Y');

        $pdf = PDF::loadView('pdf.multiCpos', $data);

        return $pdf->download('RPO#' . $cpo[0]->rpo_number . '.pdf');
    }

    public function generatePdfs(Request $request)
    {
        $cpos = Cpo::whereIn('id', explode(',', $request->id))->get();



        $data['title'] = 'Multi Selected CPOS';
        $data['date'] = date('m/d/Y');
        $data['cpos'] = $cpos;

        $pdf = PDF::loadView('pdf.multiCpos', $data);

        return $pdf->download('Multiple CPOs.pdf');
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