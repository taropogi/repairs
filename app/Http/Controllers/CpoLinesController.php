<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Cpo;
use App\Models\CpoLine;
use Illuminate\Http\Request;
use App\Models\CpoLineComment;
use App\Events\CpoUpdated;

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

        Activity::create([
            'action' => 'Create CPO Line',
            'description' => 'Created CPO: Line ' . $newLine->line_number . ' in CPO #' . $cpo->formatted_id,
            'user_id' => auth()->user()->id,
        ]);




        $cpo->touch();

        return response()->json([
            'cpo' => $cpo,
            'newLine' => $newLine
        ]);
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

        $userPermissions = auth()->user()->permissions ?? [];
        $userIsAdmin = auth()->user()->is_admin;
        $lineFields = [];
        foreach ($userPermissions as $permission) {
            if ($permission['name'] === 'cpo-edit') {
                $lineFields = $permission['lineFields'];
                break;
            }
        }

        $cpoLine = CpoLine::where('id', $request->id)->first();


        if (in_array('description', $lineFields) || $userIsAdmin) {
            $cpoLine->description = $request->description;
        }



        if (
            (in_array('price', $lineFields) || $userIsAdmin) &&
            is_numeric($request->price)
        ) {
            $cpoLine->price = $request->price;
        }

        if (in_array('hcopy', $lineFields) || $userIsAdmin) {
            $cpoLine->hcopy = $request->hcopy;
        }

        if (in_array('doc_date', $lineFields) || $userIsAdmin) {
            $cpoLine->doc_date = $request->doc_date;
        }


        if (
            (in_array('qty_returned', $lineFields) || $userIsAdmin) &&
            is_numeric($request->qty_returned)
        ) {
            $cpoLine->qty_returned = $request->qty_returned;
        }



        if (
            (in_array('unit', $lineFields) || $userIsAdmin)

        ) {
            $cpoLine->unit = $request->unit;
        }


        if (
            (in_array('qty_inspect', $lineFields) || $userIsAdmin) &&
            is_numeric($request->qty_inspect)
        ) {
            $cpoLine->qty_inspect = $request->qty_inspect;
        }

        if (
            (in_array('date_inspected', $lineFields) || $userIsAdmin)
        ) {
            $cpoLine->date_inspected = $request->date_inspected;
        }

        if (
            (in_array('good_condition', $lineFields) || $userIsAdmin) &&
            is_numeric($request->good_condition)
        ) {
            $cpoLine->good_condition = $request->good_condition;
        }

        if (
            (in_array('minor_repair_clean', $lineFields) || $userIsAdmin) &&
            is_numeric($request->minor_repair_clean)
        ) {
            $cpoLine->minor_repair_clean = $request->minor_repair_clean;
        }

        if (
            (in_array('repair_parts_needed', $lineFields) || $userIsAdmin) &&
            is_numeric($request->repair_parts_needed)
        ) {
            $cpoLine->repair_parts_needed = $request->repair_parts_needed;
        }

        if (
            (in_array('damaged', $lineFields) || $userIsAdmin) &&
            is_numeric($request->damaged)
        ) {
            $cpoLine->damaged = $request->damaged;
        }

        if (
            (in_array('date', $lineFields) || $userIsAdmin)
        ) {
            $cpoLine->date = $request->date;
        }

        if (
            (in_array('order_number', $lineFields) || $userIsAdmin)
        ) {
            $cpoLine->order_number = $request->order_number;
        }

        $cpoLine->update();


        // update comment

        if (in_array('comments', $lineFields) || $userIsAdmin) {
            $cpoLineComment = CpoLineComment::firstOrNew(['cpo_line_id' => $cpoLine->id, 'user_id' => auth()->user()->id]);
            if ($request->user_comment == '') {
                $cpoLineComment->delete();
            } else {
                $cpoLineComment->comment = $request->user_comment;
                $cpoLineComment->commented_by = auth()->user()->name;
                $cpoLineComment->save();
            }
        }




        $cpo = Cpo::find($cpoLine->cpo_id);

        // Log activity
        Activity::create([
            'action' => 'Update CPO Line',
            'description' => 'Updated CPO: Line ' . $cpoLine->line_number . ' in CPO #' . $cpo->formatted_id,
            'user_id' => auth()->user()->id,
        ]);




        $cpo->touch();

        event(new CpoUpdated($cpo));
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
        // sleep(1);
        $cpoLine = CpoLine::where('id', $request->id)->first();
        $cpoLine->delete();

        Activity::create([
            'action' => 'Delete CPO Line',
            'description' => 'Deleted CPO: Line ' . $cpoLine->line_number . ' in CPO #' . $cpoLine->cpo->formatted_id,
            'user_id' => auth()->user()->id,
        ]);

        return $cpoLine;
    }
}
