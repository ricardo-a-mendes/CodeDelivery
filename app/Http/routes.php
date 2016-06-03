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
    echo 'teste';
    //return view('welcome');
});

Route::pattern('id', '\d+');
Route::group(['prefix' => 'admin'], function(){

    //Clients
    Route::get('client/list', 'Admin\ClientController@index')->name('clientList');
    Route::post('client', 'Admin\ClientController@create')->name('clientCreate');
    Route::get('client/add', 'Admin\ClientController@add')->name('clientAdd');
    Route::get('client/edit/{id}', 'Admin\ClientController@edit')->name('clientEdit');
    Route::put('client/update/{id}', 'Admin\ClientController@update')->name('clientUpdate');
    Route::get('client/delete/{id}', 'Admin\ClientController@delete')->name('clientDelete');
});