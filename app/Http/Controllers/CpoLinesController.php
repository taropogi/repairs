<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\CpoLine;
use Illuminate\Http\Request;
use App\Models\CpoLineComment;

class CpoLinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


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

        $newLine = new CpoLine();
        $newLine->line_number = $cpo->lines()->count() + 1;
        $newLine->cpo_id = $cpo->id;
        $newLine->save();

        $cpoLineComment = new CpoLineComment();
        $cpoLineComment->cpo_line_id = $newLine->id;
        $cpoLineComment->user_id = auth()->user()->id;
        $cpoLineComment->comment = '';
        $cpoLineComment->commented_by = auth()->user()->name;
        $cpoLineComment->save();




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
        $cpoLine->unit = $request->unit;
        $cpoLine->qty_inspect = $request->qty_inspect;
        $cpoLine->good_condition = $request->good_condition;
        $cpoLine->minor_repair_clean = $request->minor_repair_clean;
        $cpoLine->repair_parts_needed = $request->repair_parts_needed;
        $cpoLine->date = $request->date;
        $cpoLine->order_number = $request->order_number;
        $cpoLine->comments = $request->comments;
        $cpoLine->update();


        // update comment
        $cpoLineComment = CpoLineComment::firstOrNew(['cpo_line_id' => $cpoLine->id, 'user_id' => auth()->user()->id]);
        $cpoLineComment->user_id = auth()->user()->id;
        $cpoLineComment->comment = $request->user_comment ?? '';
        $cpoLineComment->commented_by = auth()->user()->name;
        $cpoLineComment->save();




        $cpo = Cpo::find($cpoLine->cpo_id);




        $cpo->touch();
        // set delay time sleep for 0.5 second
        usleep(500000);

        $response['cpoLine']    = $cpoLine;
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CpoLines  $cpoLines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        sleep(1);
        $cpoLine = CpoLine::where('id', $request->id)->first();
        $cpoLine->delete();
        return $cpoLine;
    }
}
