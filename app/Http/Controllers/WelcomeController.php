<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WelcomeController extends Controller
{
    public function index()
    {

        $all_routes = Route::getRoutes();
        $route_list = [];
        foreach ($all_routes as $route) {

            if (isset($route->action['as'])) {
                array_push($route_list, [
                    'routeName' => $route->action['as'],
                    'uri' => env('APP_URL_ROOT_FOLDER') . '/' . $route->uri
                ]);
            }
        }

        $data['data'] = [
            'app_url' => env('APP_URL'),
            'app_url_root_folder' => env('APP_URL_ROOT_FOLDER'),
            'route_list' => $route_list

        ];
        return view('layouts.app', $data);
    }
}