<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Providers\Footballs\FootballPlaceController;
use App\Http\Controllers\Providers\Footballs\DetailController;
use App\Http\Controllers\Providers\Footballs\SocialNetworkController;

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
Route::get('language/{lang}', function ($lang) {
    Session::put('locale', $lang);
    return back();
})->name('langroute');

Route::group(['middleware'=>['lang']], function(){

    Route::resource('footballs', FootballPlaceController::class);
    Route::resource('details', DetailController::class);
    Route::resource('social-networks', SocialNetworkController::class);

    Route::get('/', function () {
//    return view('welcome');
        return view('providers.dashboards.index');
    });


});

