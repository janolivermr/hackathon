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
    if (auth()->guest()) {
        return redirect('/login');
    }
    return redirect('/home');
});

Auth::routes();
Route::resource('/verify', 'VerificationController')->only(['index', 'store']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/talks', 'TalkController')->only(['index']);
    Route::resource('/meetups', 'MeetupController')->only(['store']);
});