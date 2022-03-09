<?php

use App\Http\Controllers\CpoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return $request->user();
});

//cpo
Route::post('cpo', [CpoController::class, 'create']);
Route::get('cpo', [CpoController::class, 'getCpoHeaders']);

//auth
Route::post('register', [RegisterController::class, 'create']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);