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
Route::group(['prefix' => 'admin', 'middleware' => 'auth.checkrole'], function () {

    //Clients
    Route::group(['prefix' => 'client'], function () {
        Route::get('list', 'Admin\ClientController@index')->name('adminClientList');
        Route::post('/', 'Admin\ClientController@create')->name('adminClientCreate');
        Route::get('add', 'Admin\ClientController@add')->name('adminClientAdd');
        Route::get('edit/{id}', 'Admin\ClientController@edit')->name('adminClientEdit');
        Route::put('update/{id}', 'Admin\ClientController@update')->name('adminClientUpdate');
        Route::get('delete/{id}', 'Admin\ClientController@delete')->name('adminClientDelete');
    });

    //Users
    Route::group(['prefix' => 'user'], function () {
        Route::get('list', 'Admin\UserController@index')->name('adminUserList');
        Route::post('/', 'Admin\UserController@create')->name('adminUserCreate');
        Route::get('add', 'Admin\UserController@add')->name('adminUserAdd');
        Route::get('edit/{id}', 'Admin\UserController@edit')->name('adminUserEdit');
        Route::put('update/{id}', 'Admin\UserController@update')->name('adminUserUpdate');
        Route::get('delete/{id}', 'Admin\UserController@delete')->name('adminUserDelete');
    });

    //Category
    Route::group(['prefix' => 'category'], function () {
        Route::get('list', 'Admin\CategoryController@index')->name('adminCategoryList');
        Route::post('', 'Admin\CategoryController@create')->name('adminCategoryCreate');
        Route::get('add', 'Admin\CategoryController@add')->name('adminCategoryAdd');
        Route::get('edit/{id}', 'Admin\CategoryController@edit')->name('adminCategoryEdit');
        Route::put('update/{id}', 'Admin\CategoryController@update')->name('adminCategoryUpdate');
        Route::get('delete/{id}', 'Admin\CategoryController@delete')->name('adminCategoryDelete');
    });

    //Cupom
    Route::group(['prefix' => 'cupom'], function () {
        Route::get('list', 'Admin\CupomController@index')->name('adminCupomList');
        Route::post('', 'Admin\CupomController@create')->name('adminCupomCreate');
        Route::get('add', 'Admin\CupomController@add')->name('adminCupomAdd');
        Route::get('edit/{id}', 'Admin\CupomController@edit')->name('adminCupomEdit');
        Route::put('update/{id}', 'Admin\CupomController@update')->name('adminCupomUpdate');
        Route::get('delete/{id}', 'Admin\CupomController@delete')->name('adminCupomDelete');
    });

    //Orders
    Route::group(['prefix' => 'order'], function () {
        Route::get('list', 'Admin\OrderController@index')->name('adminOrderList');
        Route::post('/', 'Admin\OrderController@create')->name('adminOrderCreate');
        Route::get('add', 'Admin\OrderController@add')->name('adminOrderAdd');
        Route::get('edit/{id}', 'Admin\OrderController@edit')->name('adminOrderEdit');
        Route::put('update/{id}', 'Admin\OrderController@update')->name('adminOrderUpdate');
        Route::get('delete/{id}', 'Admin\OrderController@delete')->name('adminOrderDelete');
    });
});

Route::group(['prefix' => 'customer'], function () {
    Route::group(['prefix' => 'order'], function () {
        Route::get('list', 'OrderController@index')->name('customerOrderList');
        Route::get('create/{id?}', 'OrderController@create')->name('customerOrderNew');
        Route::get('edit', 'OrderController@create')->name('customerOrderEdit');
        Route::post('product/search', 'OrderController@search')->name('customerOrderItemSearch');
        Route::post('addItem', 'OrderController@addItems')->name('customerOrderAddItems');
    });
});

Route::auth();

Route::get('/home', 'HomeController@index');