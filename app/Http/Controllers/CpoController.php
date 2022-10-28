<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\CpoLine;
use App\Models\HeaderStatus;
use App\Models\HeaderStatusHistory;
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
        $response['cpo']['status'] = $cpo->status;
        $response['header_statuses'] = HeaderStatus::all();

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

        $cpo = Cpo::find($request->cpoId);

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

        $cpo->touch();

        return $request;
    }
    public function getCpoHeaders(Request $request)
    {

        $cpos = Cpo::orderBy('updated_at', 'desc');
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



        $cpos = $cpos->with('status')->get();
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
    public function update(Request $request)
    {
        $cpo = Cpo::find($request->id);

        $cpo->customer_name = $request->customerName;
        $cpo->customer_address = $request->customerAddress;
        $cpo->contact_number = $request->contactNumber;
        $cpo->rpo_number = $request->rpoNumber;
        $cpo->prepared_by = $request->preparedBy;
        $cpo->authorized_by = $request->authorizedBy;
        $cpo->locked = $request->locked;


        if ($cpo->status_id !== $request->status_id) {
            $cpo->status_history()->create([
                'header_status_id' => $request->status_id,
                'changed_by' => auth()->user()->id
            ]);

            $cpo->status_id = $request->status_id;
        }




        $cpo->update();








        return $cpo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cpo  $cpo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cpo = Cpo::find($request->cpoId);
        $cpo->delete();
        return $request;
    }
}