<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('guests')->group(function () {
    Route::get('create', 'GuestController@create')->name('guest.create');
    Route::get('list', 'GuestController@list')->name('guest.list');
    Route::get('{type}/', 'GuestController@index')->name('guests');
    Route::get('{guest}/edit', 'GuestController@edit')->name('guest.edit');
    Route::post('{type}/store', 'GuestController@store')->name('guest.store');
    Route::patch('{guest}/{type}/update', 'GuestController@update')->name('guest.update');
    Route::delete('{guest}/delete', 'GuestController@destroy')->name('guest.delete');
});
