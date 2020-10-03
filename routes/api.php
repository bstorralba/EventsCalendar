<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventCalendarController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getEventsOfCurrMonth', 'App\Http\Controllers\EventCalendarController@getEventsOfCurrMonth');

Route::group(['prefix' => 'eventCalendar'], function(){
	Route::post('addEventDates', 'App\Http\Controllers\EventCalendarController@addEventDates');
});
