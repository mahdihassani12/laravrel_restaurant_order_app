<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'Api\AuthController@login');
//    Route::post('register', 'Api\AuthController@register');
//    Route::post('logout', 'Api\AuthController@logout');
//    Route::post('profile', 'Api\AuthController@profile');
//    Route::post('refresh', 'Api\AuthController@refresh');
});

Route::get('/getData','Api\insideOrderController@getData')->name('getData');
Route::post('/store','Api\insideOrderController@store')->name('store');
Route::post('/outsideStore','Api\OutsideController@outsideStore')->name('outsideStore');
Route::get('loadInsideData/{id}','Api\insideOrderController@loadInsideData')->name('loadInsideData');
Route::get('getMenu','Api\insideOrderController@getMenu')->name('getMenu');
Route::match(['post','put'],'updateInsideOrder/{id}','insideOrderController@updateInsideOrder')->name('updateInsideOrder');

