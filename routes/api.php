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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('user/login' ,'Api\UserAuthController@login');

Route::post('user/fblogin' ,'Api\UserAuthController@fblogin');

Route::post('user/fbcreate','Api\UserAuthController@fbcreate');

Route::post('user/create','Api\UserAuthController@create');