<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CpoController;
use App\Http\Controllers\CpoLinesController;
use App\Http\Controllers\ExportListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
// use App\Http\Controllers\RegisterController;


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



Route::middleware('auth:sanctum')->get('user', function (Request $request) { // this is for token authentication and SPA authentication
    return $request->user();
});

//cpo
Route::post('cpo', [CpoController::class, 'create']);
Route::post('cpo/update', [CpoController::class, 'update']);
Route::get('cpo', [CpoController::class, 'getCpoHeaders']);
Route::post('cpo/by/status', [CpoController::class, 'getHeadersByStatus']);
Route::post('cpo/changed/status', [CpoController::class, 'getHeadersChangedStatus']);
Route::post('cpo/by/modified', [CpoController::class, 'getHeadersByModified']);
Route::get('cpo/{cpo}', [CpoController::class, 'show']);
Route::get('cpo/lines/{cpo}', [CpoController::class, 'getCpoLines']);
Route::post('cpo/lines/updateAllLines', [CpoController::class, 'updateAllLines']);
Route::post('cpo/destroy', [CpoController::class, 'destroy']);
Route::post('cpo/destroy/multi', [CpoController::class, 'destroyMulti']);
Route::post('cpo/selected', [CpoController::class, 'selectedCpos']);
Route::post('cpo/selected/update/status', [CpoController::class, 'changeStatusSelectedCpos']);

//cpo line
Route::post('cpoline', [CpoLinesController::class, 'store']);
Route::post('cpoline/destroy', [CpoLinesController::class, 'destroy']);
Route::post('cpoline/update', [CpoLinesController::class, 'update']);
Route::get('cpoline', [CpoLinesController::class, 'index']);


//auth
Route::post('register', [UserController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::get('login', [LoginController::class, 'login']);


//users
Route::get('users/list', [UserController::class, 'getUserList']);



//export
Route::get('export/criteria/data', [ExportListController::class, 'getCriteriaData']);