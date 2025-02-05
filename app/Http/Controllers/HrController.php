<?php

namespace App\Http\Controllers;

use App\Models\HrEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HrController extends Controller
{
    public function getPreparedBySuggestions()
    {
        $qry = HrEmployee::select(
            'employee_id as id',
            DB::raw("UPPER(CONCAT(emp_firstname, ' ', emp_lastname)) as name"),
            DB::raw("UPPER(ohrm_job_title.job_title) as position"),
            DB::raw("UPPER(emp_firstname) as firstName"),
            DB::raw("UPPER(emp_lastname) as lastName")
        );

        $qry->join('ohrm_job_title', 'ohrm_job_title.id', '=', 'hs_hr_employee.job_title_code');
        $qry->where('ohrm_job_title.job_title', 'not like', '%promodiser%');
        $qry->where('ohrm_job_title.job_title', 'not like', '%driver%');
        $qry->where('ohrm_job_title.job_title', 'not like', '%helper%');

        $qry->whereNull('termination_id');

        // $qry->limit(50);
        $suggestions = $qry->get();

        return response()->json(
            [
                'suggestions' => $suggestions
            ]
        );
    }
}
