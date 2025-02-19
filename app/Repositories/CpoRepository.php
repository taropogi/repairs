<?php

namespace App\Repositories;

use App\Models\Cpo;
use Illuminate\Support\Facades\DB;
// use App\Models\CpoLine;
// use App\Models\CpoLineComment;
use Illuminate\Http\Request;

class CpoRepository implements CpoRepositoryInterface
{
    public function store()
    {
        $request = request();

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


        return $new_cpo;
    }

    public function getCpoTally()
    {
        $query = Cpo::select(
            DB::raw('count(*) as total'),
            'created_by',
            'users.name as created_by_name'
        )
            ->join('users', 'cpos.created_by', '=', 'users.id')
            ->whereDate('cpos.created_at', '=', date('Y-m-d'))
            ->groupBy('created_by', 'users.name');

        if (!auth()->user()->canAccessOtherCpos()) {
            $query = $query->where('created_by', auth()->user()->id);
        }


        $tally = $query->get();

        return $tally;
    }
}
