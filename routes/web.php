<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
//authentication process
Route::get('/','UsersController@login')->name('login');
Route::get('logout', 'UsersController@logout')->name('logout');
Route::get('register','UsersController@register')->name('register');
Route::post('storeUser','UsersController@storeUser')->name('storeUser');
Route::post('authenticateLogin','UsersController@authenticateLogin')->name('authenticateLogin');

//Group middleware for Admin
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/adminDashboard','HomeController@index')->name('adminDashboard');
    Route::resource('floors','floorsController');
    Route::resource('tables','tablesController');
    Route::resource('categories','categoriesController');
    Route::resource('menus','menusController');
    Route::get('/getMenus','menusController@getMenu')->name('getMenus');
    Route::get('userCreate','UsersController@create')->name('users.create');
    Route::get('userIndex','UsersController@index')->name('users.index');
    Route::post('userStore','UsersController@store')->name('users.store');
    Route::get('userEdit/{id}','UsersController@edit')->name('users.edit');
    Route::put('userUpdate/{id}','UsersController@update')->name('users.update');
    Route::delete('userDestroy/{id}','UsersController@destroy')->name('users.destroy');
    Route::resource('outsideOrder','OutsideController');
    Route::get('outsideContinueOrder','OutsideController@outsideContinueOrder')->name('outsideContinueOrder');

    Route::post('paymentInsideCreate','PaymentController@paymentInsideCreate')->name('paymentInsideCreate');
    Route::get('paymentInsideList','PaymentController@paymentInsideList')->name('paymentInsideList');


    Route::post('paymentOutsideCreate','PaymentController@paymentOutsideCreate')->name('paymentOutsideCreate');
    Route::get('paymentOutsideList','PaymentController@paymentOutsideList')->name('paymentOutsideList');

    Route::get('reportInside','ReportController@reportInside')->name('reportInside');
    Route::get('reportOutside','ReportController@reportOutside')->name('reportOutside');

    Route::get('getInsideReport','ReportController@getInsideReport')->name('getInsideReport');
    Route::get('getOutsideReport','ReportController@getOutsideReport')->name('getOutsideReport');
    Route::get('reportAll','ReportController@reportAll')->name('reportAll');
    Route::get('getReportAll','ReportController@getReportAll')->name('getReportAll');
});

//Group middleware for Order
Route::group(['middleware' => ['auth', 'order']], function () {
    Route::get('order','HomeController@orderDashboard')->name('orderDashboard');
    Route::resource('orders','insideOrderController');
    Route::get('continueOrder','insideOrderController@continueOrder')->name('continueOrder');
    Route::post('orderSearch','insideOrderController@orderSearch')->name('orderSearch');
    Route::resource('outsideOrder','OutsideController');
    Route::get('outsideContinueOrder','OutsideController@outsideContinueOrder')->name('outsideContinueOrder');
    Route::get('loadData/{id}','OutsideController@loadData')->name('loadData');
    Route::get('loadInsideData/{id}','insideOrderController@loadInsideData')->name('loadInsideData');
    Route::get('getMenu','insideOrderController@getMenu')->name('order.getMenu');

    Route::match(['post','put'],'updateOutsideOrder{id}','OutsideController@updateOutsideOrder')->name('updateOutsideOrder');
    Route::match(['post','put'],'updateInsideOrder{id}','insideOrderController@updateInsideOrder')->name('updateInsideOrder');
});

//Group middleware for Kitchen
Route::group(['middleware' => ['auth', 'kitchen']], function () {
    Route::get('kitchen','HomeController@kitchenDashboard')->name('kitchenDashboard');
    Route::get('kitchenSearch','KitchenController@kitchenSearch')->name('kitchenSearch');
    Route::get('getOrders','KitchenController@getOrders')->name('getOrders');
    Route::get('getSendOrders','KitchenController@getSendOrders')->name('getSendOrders');

    Route::post('sendOrders','KitchenController@sendOrders')->name('sendOrders');

    Route::get('kitchenOutsideSearch','KitchenController@kitchenOutsideSearch')->name('kitchenOutsideSearch');
    Route::get('getOutsideOrders','KitchenController@getOutsideOrders')->name('getOutsideOrders');
    Route::get('getOutsideSendOrders','KitchenController@getOutsideSendOrders')->name('getOutsideSendOrders');

    Route::post('sendOutsideOrders','KitchenController@sendOutsideOrders')->name('sendOutsideOrders');
    Route::post('printInside','KitchenController@printInside')->name('printInside');

    Route::get('getNotification','KitchenController@getNotification')->name('getNotification');
    Route::get('sendOrdersForPrint','KitchenController@sendOrdersForPrint')->name('sendOrdersForPrint');
    Route::get('sendOutOrdersForPrint','KitchenController@sendOutOrdersForPrint')->name('sendOutOrdersForPrint');

});

//Group middleware for Payment
Route::group(['middleware' => ['auth', 'accountant']], function () {
    Route::get('Payment','HomeController@accountantDashboard')->name('accountantDashboard');
    Route::post('paymentInsideCreate','PaymentController@paymentInsideCreate')->name('paymentInsideCreate');
    Route::get('paymentInsideList','PaymentController@paymentInsideList')->name('paymentInsideList');
    Route::post('paymentInsideUpdate','PaymentController@paymentInsideUpdate')->name('paymentInsideUpdate');
    Route::get('paymentPayedInsideList','PaymentController@paymentPayedInsideList')->name('paymentPayedInsideList');

    Route::post('paymentOutsideCreate','PaymentController@paymentOutsideCreate')->name('paymentOutsideCreate');
    Route::get('paymentOutsideList','PaymentController@paymentOutsideList')->name('paymentOutsideList');
    Route::post('paymentOutsideUpdate','PaymentController@paymentOutsideUpdate')->name('paymentOutsideUpdate');
    Route::get('paymentPayedOutsideList','PaymentController@paymentPayedOutsideList')->name('paymentPayedOutsideList');
    Route::get('outSideCreate','PaymentController@outSideCreate')->name('payment.outSideCreate');
    Route::post('store','PaymentController@store')->name('payment.store');

    Route::get('inSideCreate','PaymentController@inSideCreate')->name('payment.inSideCreate');
    Route::post('insideStore','PaymentController@insideStore')->name('payment.insideStore');

    Route::get('paymentGetMenu','PaymentController@paymentGetMenu')->name('paymentGetMenu');
    Route::get('paymentInGetMenu','PaymentController@paymentInGetMenu')->name('paymentInGetMenu');
    Route::get('paymentInSearch','PaymentController@paymentInSearch')->name('paymentInSearch');

    Route::get('paymentOutSearch','PaymentController@paymentOutSearch')->name('paymentOutSearch');

});




//Group middleware for Accountant
Route::group(['middleware' => ['auth', 'accountant']], function () {
    Route::get('accountant','HomeController@accountantDashboard')->name('accountantDashboard');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
