<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::pattern('id', '\d+');
Route::group(['prefix' => 'admin'], function(){

    //Clients
    Route::get('client/list', 'Admin\ClienteController@index')->name('clientList');
    Route::post('client', 'Admin\ClienteController@create')->name('clientCreate');
    Route::get('client/add', 'Admin\ClienteController@add')->name('clientAdd');
    Route::get('client/edit/{id}', 'Admin\ClienteController@edit')->name('clientEdit');
    Route::put('client/update/{id}', 'Admin\ClienteController@update')->name('clientUpdate');
    Route::get('client/delete/{id}', 'Admin\ClienteController@delete')->name('clientDelete');
});