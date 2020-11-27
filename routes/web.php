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

Route::group(['prefix'=>'admin'], function (){
    Route::get('/','\App\Http\Controllers\BackendController@show')->name('admin.index');
});
