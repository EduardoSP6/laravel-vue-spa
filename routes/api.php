<?php

use Illuminate\Http\Request;

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

Route::get('/properties/avaliable', ['as' => 'properties.avaliable', 'uses' => 'PropertyController@getAvaliable']);
Route::resource('properties', 'PropertyController');
Route::resource('contracts', 'ContractController')->except('destroy');
