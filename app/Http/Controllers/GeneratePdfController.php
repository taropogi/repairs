<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Cpo;
use App\Traits\FormatLines;
use Illuminate\Support\Str;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Exports\ExportCpoLists;
use App\Exports\ExportCpoByStatus;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class GeneratePdfController extends Controller
{
    use FormatLines;
    public function __construct()
    {
        $this->middleware('auth');
    }


    private function generateCpoPdf($cpo_id)
    {

        $this->sortLineNumbers($cpo_id);
        $cpo = Cpo::where('id', $cpo_id)->get();

        $data['title'] = 'RPO#' . $cpo[0]->id;
        $data['cpos'] = $cpo;
        $data['date'] = date('m/d/Y');
        $data['random_str'] = Str::random(10);
        $imagePath = public_path('images/times-trans.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $data['image_src'] = 'data:image/png;base64,' . $imageData;

        $pdf = PDF::loadView('pdf.multiCpos', $data);

        $file_name = $cpo[0]->id . '-' . date("Y-m-d h-i-s a", time()) . '.pdf';
        Storage::put('public/pdfs/rpo/' . $cpo[0]->id . '/' . $file_name, $pdf->output());

        $cpo[0]->pdf_history()->create(
            [
                'created_by' => auth()->user()->id,
                'file_name' => $file_name
            ]
        );
    }

    public function generatePdf(Request $request)
    {

        // $this->sortLineNumbers($request->id);
        $this->generateCpoPdf($request->id);
        $cpo = Cpo::where('id', $request->id)->get();
        // $this->sortLineNumbers($cpo);
        $data['title'] = 'Multi Selected CPOS';
        $data['cpos'] = $cpo;
        $data['date'] = date('m/d/Y');
        $data['random_str'] = Str::random(10);


        $imagePath = public_path('images/times-trans.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $data['image_src'] = 'data:image/png;base64,' . $imageData;



        $pdf = PDF::loadView('pdf.multiCpos', $data)
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'margin-top' => 0.5 * 72, // 0.5 inches in points (1 inch = 72 points)
                'margin-right' => 0.5 * 72,
                'margin-bottom' => 0.5 * 72,
                'margin-left' => 0.5 * 72,
            ]);

        // return $pdf->stream('RPO#' . $cpo[0]->formatted_id . '.pdf');

        // Log the activity
        auth()->user()->activities()->create([
            'action' => 'Downloaded',
            'description' => 'Downloaded RPO#' . $cpo[0]->formatted_id . ' PDF'
        ]);

        return $pdf->download('PULL-OUT-FORM#' . $cpo[0]->formatted_id . '.pdf');
    }


    public function generatePdfs(Request $request)
    {
        /**
         * Generate multiple PDFs based on the provided IDs in the request.
         *
         * This method takes a comma-separated list of IDs from the request,
         * generates individual PDFs for each ID, and then combines them into
         * a single PDF for download.
         *
         * @param \Illuminate\Http\Request $request The incoming request containing the IDs.
         * @return \Illuminate\Http\Response The response containing the generated PDF for download.
         */
        $ids_arr = explode(',', $request->id);

        foreach ($ids_arr as $id) {
            $this->generateCpoPdf($id);
        }

        $cpos = Cpo::whereIn('id', $ids_arr)->get();

        $validCpos = $cpos->filter(function ($cpo) {
            return $cpo->valid_lines_count > 0;
        });

        $data['cpos'] = $validCpos;



        $data['title'] = 'Multi Selected CPOS';
        $data['date'] = date('m/d/Y');
        // $data['cpos'] = $cpos;

        $data['random_str'] = Str::random(10);


        $imagePath = public_path('images/times-trans.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $data['image_src'] = 'data:image/png;base64,' . $imageData;



        $pdf = PDF::loadView('pdf.multiCpos', $data);

        Activity::create([
            'action' => 'Downloaded PDFs',
            'description' => 'Downloaded Multiple CPOs PDF for valid CPOs only: ' . $data['cpos']->pluck('id')->implode(','),
            'user_id' => auth()->user()->id,
            'app_version' => $request->app_version ?? 'N/A',
        ]);



        return $pdf->download('Multiple CPOs.pdf');
    }

    public function listByCpoStatusPdf(Request $request)
    {
        Activity::create([
            'action' => 'Downloaded PDF',
            'description' => 'Downloaded CPO List PDF. Status: ' . $this->statusNames(),
            'user_id' => auth()->user()->id
        ]);

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
                $cpos = Cpo::whereIn('status_id', explode(',', $request->status_id));
                if (!auth()->user()->canAccessOtherCpos()) {
                    $cpos = $cpos->where('created_by', auth()->user()->id);
                }
                $cpos = $cpos->get();
                if (count($cpos) > 0) {

                    $data['cpos'] =  $cpos;
                }
            }

            if ($request->cpo_modified_from && $request->cpo_modified_to) {
                // dd($request->cpo_modified_from . ' ' . $request->cpo_modified_to);
                $cpos_modified = Cpo::whereRaw(DB::raw("Date(updated_at) >= '" . $request->cpo_modified_from . "'"))
                    ->whereRaw(DB::raw("Date(updated_at) <= '" . $request->cpo_modified_to . "'"))
                    ->whereRaw(DB::raw('updated_at <> created_at'));

                if (!auth()->user()->canAccessOtherCpos()) {
                    $cpos_modified = $cpos_modified->where('created_by', auth()->user()->id);
                }

                $cpos_modified = $cpos_modified->get();

                // dd($cpos_modified);

                $data['cpos_modified'] =  $cpos_modified;
                $data['modified_from'] =  $request->cpo_modified_from;
                $data['modified_to'] =  $request->cpo_modified_to;
            };

            if ($request->cpo_changed_date_from && $request->cpo_changed_date_to) {
                $query = Cpo::join('header_status_histories as history', 'cpos.id', '=', 'history.cpo_id')
                    ->join('header_statuses as status_to', 'status_to.id', '=', 'history.header_status_id')
                    ->join('header_statuses as status_from', 'status_from.id', '=', 'history.old_status_id')
                    ->select('cpos.id', 'cpos.customer_name', 'cpos.rpo_number', 'status_to.status as status_new', 'status_from.status as status_old')
                    ->selectRaw('date(history.updated_at) as changed_date')
                    ->whereDate('history.updated_at', '>=', $request->cpo_changed_date_from)
                    ->whereDate('history.updated_at', '<=', $request->cpo_changed_date_to)
                    ->whereNotNull('history.old_status_id')
                    ->where('history.header_status_id', $request->cpo_changed_status_to);

                if ($request->cpo_changed_current_only && ($request->cpo_changed_current_only === 'true')) {
                    $query->where('cpos.status_id', $request->cpo_changed_status_to);
                }

                if (!auth()->user()->canAccessOtherCpos()) {
                    $query = $query->where('cpos.created_by', auth()->user()->id);
                }

                $cpos_changed_status = $query->get();
                // $query = DB::table('header_status_histories as history')
                //     ->join('cpos', 'cpos.id', '=', 'history.cpo_id')
                //     ->join('header_statuses as status_to', 'status_to.id', '=', 'history.header_status_id')
                //     ->join('header_statuses as status_from', 'status_from.id', '=', 'history.old_status_id')
                //     ->select('cpos.id', 'cpos.customer_name', 'cpos.rpo_number', 'status_to.status as status_new', 'status_from.status as status_old')
                //     ->selectRaw('date(history.updated_at) as changed_date')
                //     ->whereRaw("Date(history.updated_at) >= '" . $request->cpo_changed_date_from . "'")
                //     ->whereRaw("Date(history.updated_at) <= '" . $request->cpo_changed_date_to . "'")
                //     ->whereRaw("history.old_status_id is not null")
                //     ->where("history.header_status_id", $request->cpo_changed_status_to);

                // if ($request->cpo_changed_current_only && ($request->cpo_changed_current_only === 'true')) {
                //     $query->where("cpos.status_id", $request->cpo_changed_status_to);
                // }

                // $cpos_changed_status = $query->get();



                if (count($cpos_changed_status)) {
                    $data['cpos_changed_status'] =  $cpos_changed_status;
                }

                $data['changed_status_from'] =  $request->cpo_changed_date_from;
                $data['changed_status_to'] =  $request->cpo_changed_date_to;
            }

            $imagePath = public_path('images/times-trans.png');
            $imageData = base64_encode(file_get_contents($imagePath));
            $data['image_src'] = 'data:image/png;base64,' . $imageData;

            $pdf = PDF::loadView('pdf.cpoListByStatus', $data);

            return  $pdf->download('CPO List.pdf');
        }




        $pdf = PDF::loadView('pdf.no-result');
        return  $pdf->download('NO-RESULT.pdf');
    }

    public function listByCpoStatusXls(Request $request)
    {

        // return Excel::download(new ExportCpoByStatus($request), 'CpoListByStatus.xlsx');
        Activity::create([
            'user_id' => auth()->user()->id,
            'action' => 'Downloaded Excel',
            'description' => 'Downloaded CPO List Excel: ' . $this->statusNames(),
            'user_id' => auth()->user()->id
        ]);

        return (new ExportCpoLists($request))->download('CPO List.xlsx');
    }

    private function statusNames()
    {
        $included_status_ids = request()->status_id;
        $included_status_ids_array = explode(',', $included_status_ids);
        $included_status_names = HeaderStatus::whereIn('id', $included_status_ids_array)->pluck('status')->toArray();
        return implode(', ', $included_status_names);
    }

    public function testUser()
    {
        dd(auth()->user()->id);
    }
}
