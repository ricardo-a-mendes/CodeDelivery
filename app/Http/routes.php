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

Route::get('/home', 'HomeController@index');
Route::get('/', function () {
    return redirect('/home');
});
Route::auth();
Route::pattern('id', '\d+');

//Admin Group
Route::group(['prefix' => 'admin', 'middleware' => 'auth.checkrole'], function () {

    //Clients
    Route::group(['prefix' => 'client'], function () {
        Route::get('/', 'Admin\ClientController@index')->name('admin.client.index');
        Route::post('/', 'Admin\ClientController@store')->name('admin.client.store');
        Route::get('create', 'Admin\ClientController@create')->name('admin.client.create');
        Route::get('{id}/edit', 'Admin\ClientController@edit')->name('admin.client.edit');
        Route::put('{id}', 'Admin\ClientController@update')->name('admin.client.update');
        Route::get('{id}', 'Admin\ClientController@delete')->name('admin.client.delete');
    });

    //Users
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'Admin\UserController@index')->name('admin.user.index');
        Route::post('/', 'Admin\UserController@store')->name('admin.user.store');
        Route::get('create', 'Admin\UserController@create')->name('admin.user.create');
        Route::get('{id}/edit', 'Admin\UserController@edit')->name('admin.user.edit');
        Route::put('{id}', 'Admin\UserController@update')->name('admin.user.update');
        Route::get('{id}', 'Admin\UserController@delete')->name('admin.user.delete');
    });

    //Category
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'Admin\CategoryController@index')->name('admin.category.index');
        Route::post('/', 'Admin\CategoryController@store')->name('admin.category.store');
        Route::get('create', 'Admin\CategoryController@create')->name('admin.category.create');
        Route::get('{id}/edit', 'Admin\CategoryController@edit')->name('admin.category.edit');
        Route::put('{id}', 'Admin\CategoryController@update')->name('admin.category.update');
        Route::get('{id}', 'Admin\CategoryController@delete')->name('admin.category.delete');
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

//Customer Group
Route::group(['prefix' => 'customer', 'middleware' => 'auth.checkrole'], function () {
    Route::group(['prefix' => 'order'], function () {
        Route::get('list', 'Customer\OrderController@index')->name('customerOrderList');
        Route::get('create/{id?}', 'Customer\OrderController@create')->name('customerOrderNew');
        Route::get('edit/{id}', 'Customer\OrderController@edit')->name('customerOrderEdit');
        Route::get('removeItem/{id}', 'Customer\OrderController@removeItem')->name('customerOrderItemRemove');
        Route::post('item/change', 'Customer\OrderController@itemChange')->name('customerOrderItemChange');
        Route::post('product/search', 'Customer\OrderController@search')->name('customerOrderItemSearch');
        Route::post('addItem', 'Customer\OrderController@addItems')->name('customerOrderAddItems');
    });
});

//API Group
Route::group(['prefix' => 'api', 'middleware' => 'oauth'], function () {
    /**
    Using PostMan
    1 - To Get the token
        POST => http://localhost/oauth/access_token
        Parameters (sent this information into "Body"):
            grant_type:password
            username:{User e-mail}
            password:{User Password}
            client_id:{Application ID}
            client_secret:{Application Secret}

        Example
            grant_type:password
            username:eng.rmendes@gmail.com
            password:123456
            client_id:AP_ID_01
            client_secret:secret
            password:123456

    2 - To test
        GET => http://localhost/api/teste
        Parameters (sent this information into "Header" instead "Body"):
            Authorization:{token_type} {Token}

        Example:
            Authorization:Bearer ZnTuvYONdEqMJxAsQSNQoT9vjamAZ0mb4ajMDSNp

    3 - To refresh Token
        POST => http://localhost/oauth/access_token
        Parameters (sent this information into "Body"):
            grant_type:refresh_token
            client_id:{Application ID}
            client_secret:{Application Secret}
            refresh_token:{refresh_token}

        Example:
            grant_type:refresh_token
            client_id:AP_ID_01
            client_secret:secret
            refresh_token:NLvs2LjAgPKX7vsHwEwhnL6eguLjDn1T3PSLHu4l
    */
    Route::group(['prefix' => 'client', 'middleware' => 'oauth.checkrole:client'], function () {
        Route::resource('order',
            'Api\Client\ClientCheckoutController',
            ['except' => ['create', 'edit', 'destroy']]
        );

        Route::resource('authenticated',
            'Api\Client\ClientController',
            ['except' => ['create', 'store', 'show', 'edit', 'update', 'destroy']]
        );
    });

    //Deliveryman Routes
    Route::group(['prefix' => 'deliveryman', 'middleware' => 'oauth.checkrole:deliveryman'], function () {
        Route::get('pedidos', function(){
            return [
                'id' => 1,
                'client' => 'RicardoDeliveryman',
                'total' => 10
            ];
        });
    });


});


//Add this rote (oauth/access_token) to "CodeDelivery\Http\Middleware\VerifyCsrfToken" exception ($except)
Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});
