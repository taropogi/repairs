<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\Item;
use App\Models\User;
use App\Models\CpoLine;
use App\Traits\FormatLines;
use App\Traits\GeneratePdf;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Models\CpoLineComment;
use Illuminate\Support\Facades\DB;
use App\Models\HeaderStatusHistory;
use Illuminate\Support\Facades\Auth;

class CpoController extends Controller
{
    use FormatLines, GeneratePdf;

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
            // 'rpoNumber' => ['required'],
            'preparedBy' => ['required'],
            'authorizedBy' => ['required'],
        ]);

        $new_cpo = Cpo::create([
            'customer_name' => $request->customerName,
            'customer_address' => $request->customerAddress,
            'contact_number' => $request->contactNumber,
            // 'rpo_number' => $request->rpoNumber,
            'prepared_by' => $request->preparedBy,
            'authorized_by' => $request->authorizedBy,
            'status_id' => 1,
            'oracle_customer_id' => $request->oracleId,
            'oracle_customer_shipto' => $request->oracleShipto,
            'customer_reference_number' => $request->customerReferenceNumber
        ]);

        $new_cpo->status_history()->create([
            'header_status_id' => 1,
            'changed_by' => auth()->user()->id
        ]);

        $response['cpo'] = $new_cpo;

        $response['lines'] = $request->lines;

        // insert lines to cpo
        foreach ($request->lines as $key => $item) {

            $line = new CpoLine();
            $line->line_number = $item['lineNumber'];
            $line->description = $item['description'] ?? null;

            $line->price = isset($item['price']) && is_numeric($item['price']) ? $item['price'] : null;
            $line->hcopy = $item['hcopy'] ?? null;

            $line->qty_returned = isset($item['qtyReturned']) && is_numeric($item['qtyReturned']) ? $item['qtyReturned'] : null;

            $line->unit = $item['unit'] ?? null;
            $line->qty_inspect = isset($item['qtyInspect']) && is_numeric($item['qtyInspect']) ? $item['qtyInspect'] : null;
            $line->date = $item['date'] ?? null;
            $line->good_condition = isset($item['goodCondition']) && is_numeric($item['goodCondition']) ? $item['goodCondition'] : null;
            $line->minor_repair_clean = isset($item['minorRepairClean']) && is_numeric($item['minorRepairClean']) ? $item['minorRepairClean'] : null;
            $line->repair_parts_needed = isset($item['repairPartsNeeded']) && is_numeric($item['repairPartsNeeded']) ? $item['repairPartsNeeded'] : null;
            $line->damaged = isset($item['damaged']) && is_numeric($item['damaged']) ? $item['damaged'] : null;
            $line->comments = $item['comments'] ?? null;
            $line->order_number = $item['orderNumber'] ?? null;
            $line->cpo_id = $new_cpo->id;
            $line->save();


            // update comment
            if ($item['comments'] && !empty($item['comments'])) {
                $cpoLineComment = CpoLineComment::firstOrNew(['cpo_line_id' => $line->id, 'user_id' => auth()->user()->id]);
                $cpoLineComment->user_id = auth()->user()->id;
                $cpoLineComment->comment = $item['comments'];
                $cpoLineComment->commented_by = auth()->user()->name;
                $cpoLineComment->save();
            }
        }



        // set delay time sleep for 1 second
        sleep(1);
        return $response;
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cpo  $cpo
     * @return \Illuminate\Http\Response
     */
    public function show(Cpo $cpo)
    {
        // $this->sortLineNumbers($cpo);

        $response['cpo'] = $cpo;
        $response['header_statuses'] = HeaderStatus::all();
        $response['users'] = User::select('id', 'name')->get();
        //  $response['lines'] = $cpo->lines;



        return  $response;
    }


    public function updateAllLines(Request $request)
    {

        $cpo = Cpo::find($request->cpoId);

        foreach ($request->cpoLines as $key => $item) {

            $itemObj = (object)$item;

            $cpoLine = CpoLine::find($itemObj->id);
            $cpoLine->line_number = $key + 1;
            $cpoLine->description = $itemObj->description;
            if (isset($itemObj->price) && is_numeric($itemObj->price)) {
                $cpoLine->price = $itemObj->price;
            }

            $cpoLine->hcopy = $itemObj->hcopy;

            if (isset($itemObj->qty_returned) && is_numeric($itemObj->qty_returned)) {
                $cpoLine->qty_returned = $itemObj->qty_returned;
            }
            $cpoLine->unit = $itemObj->unit;
            if (isset($itemObj->qty_inspect) && is_numeric($itemObj->qty_inspect)) {
                $cpoLine->qty_inspect = $itemObj->qty_inspect;
            }

            $cpoLine->date = $itemObj->date;
            if (isset($itemObj->good_condition) && is_numeric($itemObj->good_condition)) {
                $cpoLine->good_condition = $itemObj->good_condition;
            }
            if (isset($itemObj->minor_repair_clean) && is_numeric($itemObj->minor_repair_clean)) {
                $cpoLine->minor_repair_clean = $itemObj->minor_repair_clean;
            }
            if (isset($itemObj->repair_parts_needed) && is_numeric($itemObj->repair_parts_needed)) {
                $cpoLine->repair_parts_needed = $itemObj->repair_parts_needed;
            }
            if (isset($itemObj->damaged) && is_numeric($itemObj->damaged)) {
                $cpoLine->damaged = $itemObj->damaged;
            }

            $cpoLine->comments = $itemObj->comments;
            $cpoLine->order_number = $itemObj->order_number;
            $cpoLine->update();

            // update comment in cpo_line_comments table
            $cpoLineComment = CpoLineComment::firstOrNew(['cpo_line_id' => $cpoLine->id, 'user_id' => auth()->user()->id]);

            if (($itemObj->user_comment == '')) {
                $cpoLineComment->delete();
            } else {
                $cpoLineComment->user_id = auth()->user()->id;
                $cpoLineComment->comment = $itemObj->user_comment ?? '';
                $cpoLineComment->commented_by = auth()->user()->name;
                $cpoLineComment->save();
            }
        }


        $cpo->touch();

        return $request;
    }

    private function ensureCommentExists($cpo_id)
    {
        $cpo = Cpo::find($cpo_id);
        $cpo_lines = $cpo->lines;
        foreach ($cpo_lines as $line) {
            $comment = $line->comments()->firstOrNew(
                [
                    'cpo_line_id' => $line->id,
                    'user_id' => auth()->user()->id
                ]
            );
            if (!$comment->exists) {
                $comment->comment = '';
                $comment->commented_by = auth()->user()->name;
                $comment->save();
            }
        }
    }

    public function getCpoLines(Cpo $cpo)
    {
        $this->sortLineNumbers($cpo->id);

        $selected_cpo = Cpo::find($cpo->id);
        // $this->ensureCommentExists($cpo->id);


        $response['lines'] = $selected_cpo->lines;

        // get items from Item model 
        $response['items_uom'] = Item::select('primary_uom_code', 'primary_unit_of_measure')->distinct()->get();



        return $response;
    }


    public function getHeadersByStatus(Request $request)
    {
        $response = [];

        if ($request->status_ids && count($request->status_ids) > 0) {

            $response['cpos'] = Cpo::whereIn('status_id', $request->status_ids)->get();
        }

        return $response;
    }

    public function getHeadersByModified(Request $request)
    {

        $response = [];

        if ($request->date_from && $request->date_to) {

            $response['cpos'] = Cpo::whereRaw(DB::raw("Date(updated_at) >= '" . $request->date_from . "'"))
                ->whereRaw(DB::raw("Date(updated_at) <= '" . $request->date_to . "'"))->orderBy('updated_at', 'DESC')
                ->whereRaw(DB::raw('updated_at <> created_at'))
                ->get();
        }

        return $response;
    }

    public function getHeadersChangedStatus(Request $request)
    {
        $response = [];
        if ($request->date_from && $request->date_to && $request->status_to) {

            $query = Cpo::join('header_status_histories as history', 'cpos.id', '=', 'history.cpo_id')
                ->join('header_statuses as status_to', 'status_to.id', '=', 'history.header_status_id')
                ->join('header_statuses as status_from', 'status_from.id', '=', 'history.old_status_id')
                ->select('cpos.id', 'cpos.rpo_number', 'status_to.status as status_new', 'status_from.status as status_old')
                ->selectRaw('date(history.updated_at) as changed_date')
                ->whereDate('history.updated_at', '>=', $request->date_from)
                ->whereDate('history.updated_at', '<=', $request->date_to)
                ->whereNotNull('history.old_status_id')
                ->where('history.header_status_id', $request->status_to)
                ->whereNull('cpos.deleted_at');

            if ($request->only_current_status) {
                $query->where('cpos.status_id', $request->status_to);
            }
            $response['cpos'] = $query->get();
            // $cpos = $query->get();
            // Map the results to include the formatted_id accessor
            // $response['cpos'] = $cpos->map(function ($cpo) {
            //     $cpo->formatted_id = str_pad($cpo->id, 5, '0', STR_PAD_LEFT);
            //     return $cpo;
            // });





            // $query = DB::table('header_status_histories as history')
            //     ->join('cpos', 'cpos.id', '=', 'history.cpo_id')
            //     ->join('header_statuses as status_to', 'status_to.id', '=', 'history.header_status_id')
            //     ->join('header_statuses as status_from', 'status_from.id', '=', 'history.old_status_id')
            //     ->select('cpos.id', 'cpos.rpo_number', 'status_to.status as status_new', 'status_from.status as status_old')
            //     ->selectRaw('date(history.updated_at) as changed_date')
            //     ->whereRaw("Date(history.updated_at) >= '" . $request->date_from . "'")
            //     ->whereRaw("Date(history.updated_at) <= '" . $request->date_to . "'")
            //     ->whereRaw("history.old_status_id is not null")
            //     ->where("history.header_status_id", $request->status_to)
            //     ->whereNull("cpos.deleted_at");


            // if ($request->only_current_status) {
            //     $query->where("cpos.status_id", $request->status_to);
            // }

            // $response['cpos'] = $query->get();
        }


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

        if ($request->searchPrepared) {
            $cpos = $cpos->where('prepared_by', 'LIKE', '%' . $request->searchPrepared . '%');
        }
        if ($request->searchAuthorized) {
            $cpos = $cpos->where('authorized_by', 'LIKE', '%' . $request->searchAuthorized . '%');
        }

        if ($request->searchRpoNumber) {
            $cpos = $cpos->where('id', 'LIKE', '%' . ltrim($request->searchRpoNumber, '0') . '%');
        }



        $cpos = $cpos->take(50)->get();


        // $response['req'] = $request->header('X-XSRF-TOKEN');
        $response['cpos'] = $cpos;
        $response['limit_per_page'] = 0;


        // set delay time sleep for 0.5 second
        usleep(500000);

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
            $old_status_id = $cpo->status->id;
            Cpo::where('id',  $cpo->id)
                ->update([
                    'status_id' =>  $request->selected_status
                ]);
            if ($cpo->status->id <> $request->selected_status) {
                $cpo->status_history()->create([
                    'header_status_id' => $request->selected_status,
                    'old_status_id' =>  $old_status_id,
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

    public function getPdfHistory(Cpo $cpo)
    {

        return $cpo->pdf_history;
    }

    public function update(Request $request)
    {


        $cpo = Cpo::find($request->id);

        $cpo->customer_name = $request->customer_name;
        $cpo->customer_address = $request->customer_address;
        $cpo->contact_number = $request->contact_number;
        // $cpo->rpo_number = $request->rpo_number;
        $cpo->prepared_by = $request->prepared_by;
        $cpo->authorized_by = $request->authorized_by;
        $cpo->locked = $request->locked;

        $cpo->oracle_customer_id = $request->oracleId;
        $cpo->oracle_customer_shipto = $request->oracleShipto;
        $cpo->customer_reference_number = $request->customer_reference_number;


        if ($cpo->status_id !== $request->status_id) {
            $old_status_id = $cpo->status_id;
            $cpo->status_history()->create([
                'header_status_id' => $request->status_id,
                'old_status_id' =>  $old_status_id,
                'changed_by' => auth()->user()->id
            ]);

            $cpo->status_id = $request->status_id;
        }




        if ($cpo->update()) {
            $this->checkIfCompletedStatus($request->id, $request->status_id);
        }

        // set delay time sleep for 0.5 second
        usleep(500000);
        return $cpo;
    }

    private function checkIfCompletedStatus($cpo_id, $change_to_status_id)
    {
        if ($change_to_status_id == $this->completed_status_id) {
            Cpo::where('id', $cpo_id)->update(['locked' => true]);
            $this->generateCpoPdf($cpo_id);
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
        $this->deleteCpo($request->cpoId);


        return $request;
    }

    private function deleteCpo($cpo_id)
    {
        $cpo = Cpo::find($cpo_id);

        auth()->user()->activities()->create([
            'action' => 'Delete CPO',
            'description' => 'Deleted CPO with ID:' . $cpo->id
        ]);

        $cpo->delete();
    }

    public function destroyMulti(Request $request)
    {
        $cpos_to_delete = Cpo::whereIn('id', $request->selectedCpos)->get();




        foreach ($cpos_to_delete as $cpo) {
            $this->deleteCpo($cpo->id);
        }


        $response['cpos_deleted'] = $cpos_to_delete;


        return $response;
    }
}
