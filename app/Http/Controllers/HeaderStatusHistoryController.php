<?php

namespace App\Http\Controllers;

use App\Models\HeaderStatusHistory;
use App\Http\Requests\StoreHeaderStatusHistoryRequest;
use App\Http\Requests\UpdateHeaderStatusHistoryRequest;

class HeaderStatusHistoryController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHeaderStatusHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHeaderStatusHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeaderStatusHistory  $headerStatusHistory
     * @return \Illuminate\Http\Response
     */
    public function show(HeaderStatusHistory $headerStatusHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HeaderStatusHistory  $headerStatusHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(HeaderStatusHistory $headerStatusHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHeaderStatusHistoryRequest  $request
     * @param  \App\Models\HeaderStatusHistory  $headerStatusHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHeaderStatusHistoryRequest $request, HeaderStatusHistory $headerStatusHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeaderStatusHistory  $headerStatusHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeaderStatusHistory $headerStatusHistory)
    {
        //
    }
}
