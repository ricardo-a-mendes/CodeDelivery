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

use CodeDelivery\Models\Category;
use CodeDelivery\Models\User;

Route::get('/', function () {

    return redirect('/home');

});

Route::pattern('id', '\d+');
Route::group(['prefix' => 'admin', 'middleware' => 'auth.checkrole'], function(){

    //Clients
    Route::group(['prefix' => 'client'], function() {
        Route::get('list', 'Admin\ClientController@index')->name('clientList');
        Route::post('/', 'Admin\ClientController@create')->name('clientCreate');
        Route::get('add', 'Admin\ClientController@add')->name('clientAdd');
        Route::get('edit/{id}', 'Admin\ClientController@edit')->name('clientEdit');
        Route::put('update/{id}', 'Admin\ClientController@update')->name('clientUpdate');
        Route::get('delete/{id}', 'Admin\ClientController@delete')->name('clientDelete');
    });

    //Users
    Route::group(['prefix' => 'user'], function() {
        Route::get('list', 'Admin\UserController@index')->name('userList');
        Route::post('/', 'Admin\UserController@create')->name('userCreate');
        Route::get('add', 'Admin\UserController@add')->name('userAdd');
        Route::get('edit/{id}', 'Admin\UserController@edit')->name('userEdit');
        Route::put('update/{id}', 'Admin\UserController@update')->name('userUpdate');
        Route::get('delete/{id}', 'Admin\UserController@delete')->name('userDelete');
    });

    //Category
    Route::group(['prefix' => 'category'], function() {
        Route::get('list', 'Admin\CategoryController@index')->name('categoryList');
        Route::post('', 'Admin\CategoryController@create')->name('categoryCreate');
        Route::get('add', 'Admin\CategoryController@add')->name('categoryAdd');
        Route::get('edit/{id}', 'Admin\CategoryController@edit')->name('categoryEdit');
        Route::put('update/{id}', 'Admin\CategoryController@update')->name('categoryUpdate');
        Route::get('delete/{id}', 'Admin\CategoryController@delete')->name('categoryDelete');
    });

    //Orders
    Route::group(['prefix' => 'order'], function() {
        Route::get('list', 'Admin\OrderController@index')->name('orderList');
        Route::post('/', 'Admin\OrderController@create')->name('orderCreate');
        Route::get('add', 'Admin\OrderController@add')->name('orderAdd');
        Route::get('edit/{id}', 'Admin\OrderController@edit')->name('orderEdit');
        Route::put('update/{id}', 'Admin\OrderController@update')->name('orderUpdate');
        Route::get('delete/{id}', 'Admin\OrderController@delete')->name('orderDelete');
    });
});

Route::group(['prefix' => 'customer'], function (){
    Route::get('order/create', 'CheckoutController@create')->name('customerOrderNew');
});

Route::auth();

Route::get('/home', 'HomeController@index');