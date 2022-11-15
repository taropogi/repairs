<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $data['data'] = [
            'app_url' => env('APP_URL'),
            'app_url_root_folder' => env('APP_URL_ROOT_FOLDER'),

        ];
        return view('layouts.app', $data);
    }
}