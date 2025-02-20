<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()


    {
        $qry = HeaderStatus::orderBy('sequence_number', 'asc');
        $response['statuses'] = $qry->get();

        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        HeaderStatus::create([
            'status' => $request->name,
            'description' => $request->description
        ]);

        return response()->json(['status' => 'success', 'message' => 'Status created successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $status = HeaderStatus::find($request->id);
        $status->status = $request->status;
        $status->description = $request->description;
        $existingStatus = HeaderStatus::where('sequence_number', $request->sequence_number)->first();
        if ($existingStatus) {
            $existingStatus->sequence_number =  -1;
            $existingStatus->save();
        }

        $updatedStatusOldSequence = $status->sequence_number;
        $status->sequence_number = $request->sequence_number;
        $status->save();

        if ($existingStatus) {
            $existingStatus->sequence_number = $updatedStatusOldSequence;
            $existingStatus->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Status updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HeaderStatus::destroy($id);

        return response()->json(['status' => 'success', 'message' => 'Status deleted successfully!']);
    }
}
