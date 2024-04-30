<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\User;
use App\Traits\FormatLines;
use App\Models\HeaderStatus;
use App\Models\OracleCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    use FormatLines;
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function test()
    {
        $customers = OracleCustomer::all();

        dd($customers);
    }
}
