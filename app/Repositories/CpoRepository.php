<?php

namespace App\Repositories;

use App\Models\Cpo;
use Illuminate\Support\Facades\DB;

class CpoRepository implements CpoRepositoryInterface
{
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
