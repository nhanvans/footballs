<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Providers\Footballs\FootballPlaceController;
use App\Http\Controllers\Providers\Footballs\DetailController;
use App\Http\Controllers\Providers\Footballs\SocialNetworkController;
use App\Http\Controllers\Providers\Footballs\LocationController;
use App\Http\Controllers\Providers\Footballs\ImageController;
use App\Http\Controllers\Providers\Footballs\VideoController;
use App\Http\Controllers\Providers\Footballs\OpenTimeController;
use App\Http\Controllers\Providers\Footballs\ServiceController;

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
    Route::resource('locations', LocationController::class);
    Route::resource('images', ImageController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('open-times', OpenTimeController::class);
    Route::resource('services', ServiceController::class);
    Route::delete('services/delete', 'ServiceController@delete')->name('services.delete');

    Route::get('/', function () {
//    return view('welcome');
        return view('providers.dashboards.index');
    });


});

