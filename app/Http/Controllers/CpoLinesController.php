<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\CpoLines;
use Illuminate\Http\Request;

class CpoLinesController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cpo = Cpo::where('id', $request->id)->first();
        $cpo->lines()->create([
            'line_number' => $cpo->lines()->count() + 1,
        ]);
        return $cpo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function show(CpoLines $cpoLines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function edit(CpoLines $cpoLines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CpoLines $cpoLines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function destroy(CpoLines $cpoLines)
    {
        //
    }
}