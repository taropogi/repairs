<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\User;
use App\Traits\FormatLines;
use App\Models\HeaderStatus;
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
        $response['cpo'] = Cpo::find(6)->toSql();


        dd($response);
    }
}