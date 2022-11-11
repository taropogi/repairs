<?php

namespace App\Http\Controllers;

use App\Models\HeaderStatus;
use App\Http\Requests\StoreHeaderStatusRequest;
use App\Http\Requests\UpdateHeaderStatusRequest;

class HeaderStatusController extends Controller
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
     * @param  \App\Http\Requests\StoreHeaderStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHeaderStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeaderStatus  $headerStatus
     * @return \Illuminate\Http\Response
     */
    public function show(HeaderStatus $headerStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HeaderStatus  $headerStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(HeaderStatus $headerStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHeaderStatusRequest  $request
     * @param  \App\Models\HeaderStatus  $headerStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHeaderStatusRequest $request, HeaderStatus $headerStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeaderStatus  $headerStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeaderStatus $headerStatus)
    {
        //
    }
}