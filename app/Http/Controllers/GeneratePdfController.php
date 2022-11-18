<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Cpo;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Exports\ExportCpoByStatus;
use App\Exports\ExportCpoLists;
use Illuminate\Support\Facades\DB;
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
        if ($request->status_id || ($request->cpo_modified_from && $request->cpo_modified_to)) {
            $data['title'] = 'export';
            $data['date'] = date('m/d/Y');

            $header_statuses = HeaderStatus::all();
            $header_statuses_indexed = [];
            foreach ($header_statuses as $status) {
                $header_statuses_indexed[$status->id] = $status->status;
            }
            $data['header_statuses'] =  $header_statuses_indexed;






            if ($request->status_id) {
                $cpos = Cpo::whereIn('status_id', explode(',', $request->status_id))->get();
                if (count($cpos) > 0) {

                    $data['cpos'] =  $cpos;
                }
            }

            if ($request->cpo_modified_from && $request->cpo_modified_to) {
                // dd($request->cpo_modified_from . ' ' . $request->cpo_modified_to);
                $cpos_modified = Cpo::whereRaw(DB::raw("Date(updated_at) >= '" . $request->cpo_modified_from . "'"))
                    ->whereRaw(DB::raw("Date(updated_at) <= '" . $request->cpo_modified_to . "'"))
                    ->whereRaw(DB::raw('updated_at <> created_at'))
                    ->get();

                // dd($cpos_modified);

                $data['cpos_modified'] =  $cpos_modified;
                $data['modified_from'] =  $request->cpo_modified_from;
                $data['modified_to'] =  $request->cpo_modified_to;
            };

            $pdf = PDF::loadView('pdf.cpoListByStatus', $data);

            return  $pdf->download('CPO List.pdf');
        }


        $pdf = PDF::loadView('pdf.no-result');
        return  $pdf->download('NO-RESULT.pdf');
    }

    public function listByCpoStatusXls(Request $request)
    {

        // return Excel::download(new ExportCpoByStatus($request), 'CpoListByStatus.xlsx');

        return (new ExportCpoLists($request))->download('CPO List.xlsx');
    }

    public function testUser()
    {
        dd(auth()->user()->id);
    }
}