<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'checkadmin','prefix'=>'admin','namespace'=>'admin'],function(){

	Route::get('/','HomeController@index')->name('admin');

	Route::get('dashboard','HomeController@dashboard');

	Route::group(['prefix'=>'configurable'], function(){

		Route::get('/','SettingController@index');

		Route::get('show','SettingController@show');

		Route::post('/configuration','SettingController@setting');

	});

	Route::group(['prefix'=>'incomecalc'],function(){

		Route::get('/membership','PaymentController@index');
	});
	
	Route::group(['prefix'=>'register'],function(){

		Route::get('/register_new','HomeController@register_new_index');

		Route::post('/register_new_member','HomeController@register_new_member');

		Route::get('register_yahlife','HomeController@register_yahlife');

	});

	Route::group(['prefix'=>'genealogy'],function(){

		Route::get('/matrix','HomeController@matrix')->name('admin.genealogy.matrix');

		Route::post('/matrix_get_user','HomeController@matrix_get_user');

		Route::get('/treeview','HomeController@treeview');

		Route::any('/ajaxtreeview', 'HomeController@ajax_treeview');

		Route::get('/edit','HomeController@edit_user_index');

		Route::post('/edit','HomeController@edit_user');
	});

});

Route::group(['middleware'=>'checkmember','prefix'=>'member','namespace'=>'member'],function(){

	Route::get('/','HomeController@index')->name('member');

	Route::get('dashboard','HomeController@dashboard');

	Route::group(['prefix'=>'incomecalc'],function(){

		Route::get('/membership','PaymentController@subscription');
	});
	
	Route::group(['prefix'=>'purchase'],function(){

		Route::get('/','PaymentController@index')->name('purchase');

		Route::post('/ewallet','PaymentController@purchase_ewallet');

		Route::get('/{status}','PaymentController@purchase_paypal_process');


	});

	Route::group(['prefix'=>'register'],function(){

		Route::get('/register_new','HomeController@register_new_index');

		Route::post('/register_new_member','HomeController@register_new_member');

	});

	Route::group(['prefix'=>'genealogy'],function(){

		Route::get('/matrix','HomeController@matrix');

		Route::post('/matrix_get_user','HomeController@matrix_get_user');

		Route::get('/treeview','HomeController@treeview');

		Route::any('/ajaxtreeview', 'HomeController@ajax_treeview');
	});

});