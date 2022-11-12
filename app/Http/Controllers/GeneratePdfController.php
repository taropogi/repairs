<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use PDF;
use Illuminate\Http\Request;

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

    public function testUser()
    {
        dd(auth()->user()->id);
    }
}