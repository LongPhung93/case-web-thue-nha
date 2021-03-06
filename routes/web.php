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

Route::get('/login', '\App\Http\Controllers\UserController@showFormLogin')->name('login.show');
Route::post('/login', '\App\Http\Controllers\UserController@login')->name('login.login');
Route::get('/logout', '\App\Http\Controllers\UserController@logout')->name('login.logout');


Route::get('/register', '\App\Http\Controllers\UserController@showFormRegister');
Route::post('/register', '\App\Http\Controllers\UserController@register')->name('register');

Route::get('/','\App\Http\Controllers\FrontendController@show')->name('index');
Route::post('/search', '\App\Http\Controllers\HouseController@search')->name('house.search');

Route::group(['middleware'=>['auth']],  function () {
   Route::group(['prefix'=>'user/{id}'], function() {
       Route::get('/house-list','\App\Http\Controllers\HouseController@showHouseList')->name('user.showHouseList');
       Route::get('/order-house','\App\Http\Controllers\HouseController@showListHouse')->name('user.showListHouse');
       Route::get('/add-house','\App\Http\Controllers\HouseController@show')->name('house.add')->middleware('auth');
       Route::post('/add-house','\App\Http\Controllers\HouseController@store')->name('house.addForm')->middleware('auth');
       Route::get('/customer-list', '\App\Http\Controllers\HouseController@showCustomerHouse')->name('user.showCustomerHouse');
   });

    Route::group(['prefix'=>'house'], function () {
        Route::get('/{id}/detail/confirm','\App\Http\Controllers\BillController@confirmIndex')->name('house.confirm');
        Route::post('/{id}/detail/confirm','\App\Http\Controllers\BillController@confirmPost')->name('house.confirmPost');
        Route::get('/confirm/success','\App\Http\Controllers\BillController@success')->name('bill.success');
    });
       Route::group(['prefix'=>'admin'], function (){
           Route::get('/','\App\Http\Controllers\BackendController@show')->name('admin.index');
    });
});

Route::group(['prefix'=>'house'], function () {
    Route::get('/{id}/detail','\App\Http\Controllers\HouseController@detail')->name('house.detail');
    Route::post('/{id}/detail','\App\Http\Controllers\HouseController@rentHome')->name('house.rent');
//    Route::get('/{id}/detail/confirm','\App\Http\Controllers\BillController@confirmIndex')->name('house.confirm');
//    Route::post('/{id}/detail/confirm','\App\Http\Controllers\BillController@confirmPost')->name('house.confirmPost');
//    Route::get('/confirm/success','\App\Http\Controllers\BillController@success')->name('bill.success');
});


