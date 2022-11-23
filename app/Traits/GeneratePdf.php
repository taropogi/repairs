<?php

namespace App\Traits;

use PDF;
use App\Models\Cpo;
use Illuminate\Support\Facades\Storage;

trait GeneratePdf
{

    public function generateCpoPdf($cpo_id)
    {

        $this->sortLineNumbers($cpo_id);
        $cpo = Cpo::where('id', $cpo_id)->get();

        $data['title'] = 'RPO#' . $cpo[0]->id;
        $data['cpos'] = $cpo;
        $data['date'] = date('m/d/Y');

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
}