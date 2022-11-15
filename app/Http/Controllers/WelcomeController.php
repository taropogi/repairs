<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $data['data'] = [
            'app_url' => env('APP_URL'),

        ];
        return view('layouts.app', $data);
    }
}