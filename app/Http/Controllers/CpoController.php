<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\CpoLine;
use Illuminate\Http\Request;

class CpoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'customerName' => ['required'],
            'customerAddress' => ['required'],
            'contactNumber' => ['required'],
            'rpoNumber' => ['required'],
            'preparedBy' => ['required'],
            'authorizedBy' => ['required'],
        ]);

        Cpo::create([
            'customer_name' => $request->customerName,
            'customer_address' => $request->customerAddress,
            'contact_number' => $request->contactNumber,
            'rpo_number' => $request->rpoNumber,
            'prepared_by' => $request->preparedBy,
            'authorized_by' => $request->authorizedBy,
        ]);

        return response()->json($request);
    }
    public function getCpoHeader(Cpo $cpo)
    {
        $this->sortLineNumbers($cpo);

        $response['cpo'] = $cpo;
        $response['lines'] = $cpo->lines;

        return  $response;
    }

    private function sortLineNumbers(Cpo $cpo)
    {
        $lines = $cpo->lines;
        $line_number = 1;
        foreach ($lines as $key => $line) {
            $line->line_number = $line_number;
            $line_number++;
        }
    }

    public function updateAllLines(Request $request)
    {

        foreach ($request->cpoLines as $key => $item) {

            $itemObj = (object)$item;

            $cpoLine = CpoLine::find($itemObj->id);
            $cpoLine->line_number = $key + 1;
            $cpoLine->description = $itemObj->description;
            $cpoLine->price = $itemObj->price;
            $cpoLine->hcopy = $itemObj->hcopy;
            $cpoLine->qty_returned = $itemObj->qtyReturned;
            $cpoLine->unit = $itemObj->unit;
            $cpoLine->qty_inspect = $itemObj->qtyInspect;
            $cpoLine->good_condition = $itemObj->goodCondition;
            $cpoLine->minor_repair_clean = $itemObj->minorRepairClean;
            $cpoLine->repair_parts_needed = $itemObj->repairPartsNeeded;
            $cpoLine->damaged = $itemObj->damaged;
            $cpoLine->comments = $itemObj->comments;

            $cpoLine->update();
        }

        return $request;
    }
    public function getCpoHeaders(Request $request)
    {

        $cpos = Cpo::orderBy('id', 'desc');
        if ($request->searchName) {
            $cpos = $cpos->where('customer_name', 'LIKE', '%' . $request->searchName . '%');
        }
        if ($request->searchAddress) {
            $cpos = $cpos->where('customer_address', 'LIKE', '%' . $request->searchAddress . '%');
        }
        if ($request->searchContact) {
            $cpos = $cpos->where('contact_number', 'LIKE', '%' . $request->searchContact . '%');
        }
        if ($request->searchRpo) {
            $cpos = $cpos->where('rpo_number', 'LIKE', '%' . $request->searchRpo . '%');
        }
        if ($request->searchPrepared) {
            $cpos = $cpos->where('prepared_by', 'LIKE', '%' . $request->searchPrepared . '%');
        }
        if ($request->searchAuthorized) {
            $cpos = $cpos->where('authorized_by', 'LIKE', '%' . $request->searchAuthorized . '%');
        }



        $cpos = $cpos->get();
        return $cpos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cpo  $cpo
     * @return \Illuminate\Http\Response
     */
    public function show(Cpo $cpo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cpo  $cpo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cpo $cpo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cpo  $cpo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cpo $cpo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cpo  $cpo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cpo $cpo)
    {
        //
    }
}