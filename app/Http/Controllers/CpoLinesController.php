<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\CpoLine;
use Illuminate\Http\Request;

class CpoLinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CpoLine $cpoLine)
    {
        return ['cpoLine' => $cpoLine];
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

        $cpo->touch();

        return $cpo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function show(CpoLine $cpoLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function edit(CpoLine $cpoLine)
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
    public function update(Request $request)
    {
        $cpoLine = CpoLine::where('id', $request->id)->first();

        $cpoLine->description = $request->description;
        $cpoLine->price = $request->price;
        $cpoLine->hcopy = $request->hcopy;
        $cpoLine->qty_returned = $request->qty_returned;
        $cpoLine->update();

        $cpo = Cpo::find($cpoLine->cpo_id);
        $cpo->touch();

        return $cpoLine;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cpoLine = CpoLine::where('id', $request->id)->first();
        $cpoLine->delete();
        return $cpoLine;
    }
}