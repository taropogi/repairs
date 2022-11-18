<?php

namespace App\Http\Controllers;

use App\Models\Cpo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }
    public function test()
    {
        $cpo = Cpo::find(1);

        echo $cpo->taro;
    }
}