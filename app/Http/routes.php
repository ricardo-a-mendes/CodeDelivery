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

    //Users
    Route::get('user/list', 'Admin\UserController@index')->name('userList');
    Route::post('user', 'Admin\UserController@create')->name('userCreate');
    Route::get('user/add', 'Admin\UserController@add')->name('userAdd');
    Route::get('user/edit/{id}', 'Admin\UserController@edit')->name('userEdit');
    Route::put('user/update/{id}', 'Admin\UserController@update')->name('userUpdate');
    Route::get('user/delete/{id}', 'Admin\UserController@delete')->name('userDelete');

    //Orders
    Route::get('order/list', 'Admin\OrderController@index')->name('orderList');
    Route::post('order', 'Admin\OrderController@create')->name('orderCreate');
    Route::get('order/add', 'Admin\OrderController@add')->name('orderAdd');
    Route::get('order/edit/{id}', 'Admin\OrderController@edit')->name('orderEdit');
    Route::put('order/update/{id}', 'Admin\OrderController@update')->name('orderUpdate');
    Route::get('order/delete/{id}', 'Admin\OrderController@delete')->name('orderDelete');
});