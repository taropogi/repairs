<?php

namespace App\Http\Controllers;


use PDF;
use Illuminate\Http\Request;

class GeneratePdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function generatePdf()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('pdf.samplePdf', $data);

        return $pdf->download('cpo.pdf');
    }
}