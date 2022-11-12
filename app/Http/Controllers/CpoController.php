<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\User;
use App\Models\CpoLine;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Models\HeaderStatusHistory;
use Illuminate\Support\Facades\Auth;

class CpoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $completed_status_id = 6;
    public function __construct()
    {

        $this->middleware('auth');
    }

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

        $new_cpo = Cpo::create([
            'customer_name' => $request->customerName,
            'customer_address' => $request->customerAddress,
            'contact_number' => $request->contactNumber,
            'rpo_number' => $request->rpoNumber,
            'prepared_by' => $request->preparedBy,
            'authorized_by' => $request->authorizedBy,
            'status_id' => 1,
        ]);

        $new_cpo->status_history()->create([
            'header_status_id' => 1,
            'changed_by' => auth()->user()->id
        ]);

        $response['cpo'] = $new_cpo;


        return $response;
    }
    public function getCpoHeader(Cpo $cpo)
    {




        // $this->sortLineNumbers($cpo);

        $response['cpo'] = $cpo;
        $response['header_statuses'] = HeaderStatus::all();
        $response['users'] = User::select('id', 'name')->get();
        //  $response['lines'] = $cpo->lines;



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
            $cpoLine->qty_returned = $itemObj->qty_returned;
            $cpoLine->unit = $itemObj->unit;
            $cpoLine->qty_inspect = $itemObj->qty_inspect;
            $cpoLine->good_condition = $itemObj->good_condition;
            $cpoLine->minor_repair_clean = $itemObj->minor_repair_clean;
            $cpoLine->repair_parts_needed = $itemObj->repair_parts_needed;
            $cpoLine->damaged = $itemObj->damaged;
            $cpoLine->comments = $itemObj->comments;

            $cpoLine->update();
        }

        $cpo->touch();

        return $request;
    }

    public function getCpoLines(Cpo $cpo)
    {
        $this->sortLineNumbers($cpo);
        $response['lines'] = $cpo->lines;

        return $response;
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



        $cpos = $cpos->take(20)->with('status')->get();



        $response['cpos'] = $cpos;
        $response['limit_per_page'] = 0;

        //sleep for 1 second
        sleep(1);

        return $response;
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

    public function selectedCpos(Request $request)
    {
        $selectedPos = Cpo::whereIn('id',  $request->rpos)->get();
        $response['cpos'] = $selectedPos;
        $response['header_statuses'] = HeaderStatus::all();
        return $response;
    }


    public function changeStatusSelectedCpos(Request $request)
    {

        $not_updated_cpos =  Cpo::whereIn('id',  $request->rpos)->get();
        foreach ($not_updated_cpos as $cpo) {
            Cpo::where('id',  $cpo->id)
                ->update([
                    'status_id' =>  $request->selected_status
                ]);
            if ($cpo->status->id <> $request->selected_status) {
                $cpo->status_history()->create([
                    'header_status_id' => $request->selected_status,
                    'changed_by' => auth()->user()->id
                ]);
            }

            $this->checkIfCompletedStatus($cpo->id, $request->selected_status);
        }



        $updated_cpos =  Cpo::whereIn('id',  $request->rpos)->get();

        $response['updated_cpos'] = $updated_cpos;

        $response['not_updated_cpos'] = $not_updated_cpos;


        return $response;
    }

    public function update(Request $request)
    {
        $cpo = Cpo::find($request->id);

        $cpo->customer_name = $request->customer_name;
        $cpo->customer_address = $request->customer_address;
        $cpo->contact_number = $request->contact_number;
        $cpo->rpo_number = $request->rpo_number;
        $cpo->prepared_by = $request->prepared_by;
        $cpo->authorized_by = $request->authorized_by;
        $cpo->locked = $request->locked;


        if ($cpo->status_id !== $request->status_id) {
            $cpo->status_history()->create([
                'header_status_id' => $request->status_id,
                'changed_by' => auth()->user()->id
            ]);

            $cpo->status_id = $request->status_id;
        }




        if ($cpo->update()) {
            $this->checkIfCompletedStatus($request->id, $request->status_id);
        }


        return $cpo;
    }

    private function checkIfCompletedStatus($cpo_id, $change_to_status_id)
    {
        if ($change_to_status_id == $this->completed_status_id) {
            Cpo::where('id', $cpo_id)->update(['locked' => true]);
        } else {
            Cpo::where('id', $cpo_id)->update(['locked' => false]);
        }
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

    public function destroyMulti(Request $request)
    {
        $cpos_to_delete = Cpo::whereIn('id', $request->selectedCpos)->get();


        $cpos = Cpo::whereIn('id', $request->selectedCpos);
        $cpos->delete();

        $response['cpos_deleted'] = $cpos_to_delete;

        return $response;
    }
}