<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\Item;
use App\Models\User;
use App\Models\CpoLine;
use App\Models\Activity;
use App\Traits\FormatLines;
use App\Traits\GeneratePdf;
use App\Models\HeaderStatus;
use Illuminate\Http\Request;
use App\Models\CpoLineComment;
use Illuminate\Support\Facades\DB;
use App\Models\HeaderStatusHistory;
use Illuminate\Foundation\Inspiring;
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

    public function getRandomQuote()
    {

        $quote = Inspiring::quote();
        $quoteParts = explode(' - ', $quote);

        $quoteText = $quoteParts[0];
        $quoteAuthor = isset($quoteParts[1]) ? $quoteParts[1] : 'Unknown';

        return response()->json([
            'quote' => $quoteText,
            'author' => $quoteAuthor
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function generateRma(Request $request)
    {
        $cpo = Cpo::find($request->cpoId);
        $rmaNumber = null;
        if (!$cpo->rma_number) {
            $rmaNumber = Cpo::max('rma_number') + 1;
        }



        if (!$cpo->is_rma_final) {
            $cpo->rma_number =  $rmaNumber;
            $cpo->update();

            if ($rmaNumber) {
                auth()->user()->activities()->create([
                    'action' => 'Generate RMA',
                    'description' => 'Generated RMA for CPO with ID:' . $cpo->id . ' and RMA Number: ' . $rmaNumber
                ]);
            } else {
                auth()->user()->activities()->create([
                    'action' => 'Removed RMA',
                    'description' => 'Removed RMA for CPO with ID:' . $cpo->id
                ]);
            }
        }



        return $cpo;
    }
    public function create(Request $request)
    {

        $userPermissions = auth()->user()->permissions ?? [];
        $userIsAdmin = auth()->user()->is_admin;
        $lineFields = [];
        foreach ($userPermissions as $permission) {
            if ($permission['name'] === 'cpo-encode') {
                $lineFields = $permission['lineFields'];
                break;
            }
        }

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
            'customer_reference_number' => $request->customerReferenceNumber,
            'has_oracle_customer' => $request->has_oracle_customer ?? false
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
            $line->doc_date = $item['doc_date'] ?? null;
            $line->qty_returned = isset($item['qtyReturned']) && is_numeric($item['qtyReturned']) ? $item['qtyReturned'] : null;
            $line->date_inspected = $item['date_inspected'] ?? null;
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

            if ((in_array('comments', $lineFields) || $userIsAdmin) && isset($item['comments'])) {
                if ($item['comments'] && !empty($item['comments'])) {
                    $cpoLineComment = CpoLineComment::firstOrNew(['cpo_line_id' => $line->id, 'user_id' => auth()->user()->id]);
                    $cpoLineComment->comment = $item['comments'] ?? '';
                    $cpoLineComment->commented_by = auth()->user()->name;
                    $cpoLineComment->save();
                }
            }
        }

        auth()->user()->activities()->create([
            'action' => 'Create CPO',
            'description' => 'Created CPO with ID:' . $new_cpo->id
        ]);



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

        $userPermissions = auth()->user()->permissions;
        $userIsAdmin = auth()->user()->is_admin;
        $lineFields = [];
        foreach ($userPermissions as $permission) {
            if ($permission['name'] === 'cpo-edit') {
                $lineFields = $permission['lineFields'];
                break;
            }
        }


        $cpo = Cpo::find($request->cpoId);

        foreach ($request->cpoLines as $key => $item) {



            $itemObj = (object)$item;

            $cpoLine = CpoLine::find($itemObj->id);
            $cpoLine->line_number = $key + 1;

            if (in_array('description', $lineFields) || $userIsAdmin) {
                $cpoLine->description = $itemObj->description;
            }


            if ((in_array('price', $lineFields) || $userIsAdmin) && isset($itemObj->price) && is_numeric($itemObj->price)) {
                $cpoLine->price = $itemObj->price;
            }
            if (in_array('hcopy', $lineFields) || $userIsAdmin) {
                $cpoLine->hcopy = $itemObj->hcopy;
            }

            if (in_array('doc_date', $lineFields) || $userIsAdmin) {
                $cpoLine->doc_date = $itemObj->doc_date;
            }


            if ((in_array('qty_returned', $lineFields) || $userIsAdmin) && isset($itemObj->qty_returned) && is_numeric($itemObj->qty_returned)) {
                $cpoLine->qty_returned = $itemObj->qty_returned;
            }

            if (
                (in_array('unit', $lineFields) || $userIsAdmin) && isset($itemObj->unit)

            ) {
                $cpoLine->unit = $itemObj->unit;
            }




            if ((in_array('qty_inspect', $lineFields) || $userIsAdmin) && isset($itemObj->qty_inspect) && is_numeric($itemObj->qty_inspect)) {
                $cpoLine->qty_inspect = $itemObj->qty_inspect;
            }

            if (in_array('date_inspected', $lineFields) || $userIsAdmin) {
                $cpoLine->date_inspected = $itemObj->date_inspected;
            }

            if (
                (in_array('date', $lineFields) || $userIsAdmin)
            ) {
                $cpoLine->date = $itemObj->date;
            }

            if ((in_array('good_condition', $lineFields) || $userIsAdmin) && isset($itemObj->good_condition) && is_numeric($itemObj->good_condition)) {
                $cpoLine->good_condition = $itemObj->good_condition;
            }


            if ((in_array('minor_repair_clean', $lineFields) || $userIsAdmin) && isset($itemObj->minor_repair_clean) && is_numeric($itemObj->minor_repair_clean)) {
                $cpoLine->minor_repair_clean = $itemObj->minor_repair_clean;
            }
            if ((in_array('repair_parts_needed', $lineFields) || $userIsAdmin) && isset($itemObj->repair_parts_needed) && is_numeric($itemObj->repair_parts_needed)) {
                $cpoLine->repair_parts_needed = $itemObj->repair_parts_needed;
            }

            if ((in_array('damaged', $lineFields) || $userIsAdmin) && isset($itemObj->damaged) && is_numeric($itemObj->damaged)) {
                $cpoLine->damaged = $itemObj->damaged;
            }

            // $cpoLine->comments = $itemObj->comments;

            if (
                (in_array('order_number', $lineFields) || $userIsAdmin)
            ) {
                $cpoLine->order_number = $itemObj->order_number;
            }

            $cpoLine->update();

            // update comment in cpo_line_comments table
            if (in_array('comments', $lineFields) || $userIsAdmin) {
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
        }

        if ($cpo->rma_number && !$cpo->is_rma_final) {
            $cpo->is_rma_final = true;
            $cpo->update();
        }


        $cpo->touch();

        auth()->user()->activities()->create([
            'action' => 'Update All Lines',
            'description' => 'Updated all lines for CPO with ID:' . $cpo->id
        ]);


        // set delay time sleep for 0.5 second
        usleep(500000);
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
            $qry =  Cpo::whereIn('status_id', $request->status_ids);

            if (!auth()->user()->canAccessOtherCpos()) {
                $qry = $qry->where('created_by', auth()->user()->id);
            }

            $response['cpos'] = $qry->get();
        }

        return $response;
    }

    public function getHeadersByModified(Request $request)
    {

        $response = [];

        if ($request->date_from && $request->date_to) {
            $qry = Cpo::whereRaw(DB::raw("Date(updated_at) >= '" . $request->date_from . "'"))
                ->whereRaw(DB::raw("Date(updated_at) <= '" . $request->date_to . "'"))->orderBy('updated_at', 'DESC')
                ->whereRaw(DB::raw('updated_at <> created_at'));

            if (!auth()->user()->canAccessOtherCpos()) {
                $qry = $qry->where('created_by', auth()->user()->id);
            }

            $response['cpos'] = $qry->get();
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

            if (!auth()->user()->canAccessOtherCpos()) {
                $query = $query->where('created_by', auth()->user()->id);
            }

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



        $qry = Cpo::orderBy('updated_at', 'desc');
        if ($request->searchName) {
            $qry = $qry->where('customer_name', 'LIKE', '%' . $request->searchName . '%');
        }
        if ($request->searchAddress) {
            $qry = $qry->where('customer_address', 'LIKE', '%' . $request->searchAddress . '%');
        }
        if ($request->searchContact) {
            $qry = $qry->where('contact_number', 'LIKE', '%' . $request->searchContact . '%');
        }

        if ($request->searchPrepared) {
            $qry = $qry->where('prepared_by', 'LIKE', '%' . $request->searchPrepared . '%');
        }
        if ($request->searchAuthorized) {
            $qry = $qry->where('authorized_by', 'LIKE', '%' . $request->searchAuthorized . '%');
        }

        if ($request->searchRpoNumber) {
            // $qry = $qry->where('id', 'LIKE', '%' . ltrim($request->searchRpoNumber, '0') . '%');
            $qry = $qry->orWhere(DB::raw("LPAD(id, 5, '0')"), 'LIKE', '%' . $request->searchRpoNumber . '%');
        }

        if ($request->searchRmaNumber) {
            $qry = $qry->orWhere(DB::raw("LPAD(rma_number, 5, '0')"), 'LIKE', '%' . $request->searchRmaNumber . '%');
        }

        if ($request->searchCustomerReferenceNumber) {
            $qry = $qry->where('customer_reference_number', 'LIKE', '%' . $request->searchCustomerReferenceNumber . '%');
        }



        if (!auth()->user()->canAccessOtherCpos()) {
            $qry = $qry->where('created_by', auth()->user()->id);
        }


        $qry = $qry->skip(
            $request->input('perPage') * ($request->input('page') - 1)
        );
        $qry2 =  $qry;
        $cpos = $qry->take($request->input('perPage'))->get();


        // $cpos = $cpos->paginate(10);


        // $response['req'] = $request->header('X-XSRF-TOKEN');
        $response['cpos'] = $cpos;
        $response['limit_per_page'] = 0;
        $response['allHeadersCount'] = $qry2->count();
        $response['isLastPage'] = $response['allHeadersCount'] <= $request->input('perPage') * $request->input('page');

        // if (
        //     $request->page > 1
        // ) {
        //     Activity::create([
        //         'action' => 'Clicked Pagination Button',
        //         'description' => 'Page: ' . $request->input('page'),
        //         'user_id' => auth()->user()->id
        //     ]);
        // }



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
        $cpo->has_oracle_customer = $request->has_oracle_customer;
        // \Log::info('Has Oracle Customer: ' . ($request->has_oracle_customer ?? false));


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

        $response['cpo'] = $cpo;
        $response['request'] = $request->has_oracle_customer;
        return $response;
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
