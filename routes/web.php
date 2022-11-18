<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//pdf generate
Route::get('/generatePdf', [GeneratePdfController::class, 'generatePdf'])->name('generate-pdf');
Route::get('/generatePdfs', [GeneratePdfController::class, 'generatePdfs'])->name('generate-pdfs');
Route::get('/pdf/cpo/list/by/status', [GeneratePdfController::class, 'listByCpoStatusPdf'])->name('generate-pdf-by-status');
Route::get('/xls/cpo/list/by/status', [GeneratePdfController::class, 'listByCpoStatusXls'])->name('generate-xls-by-status');

Route::get('/testUser', [GeneratePdfController::class, 'testUser']);
Route::get('/test', [TestController::class, 'test']);

Route::get('/{path}', [WelcomeController::class, 'index'])->where('path', '^(?!path).*$');



//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');