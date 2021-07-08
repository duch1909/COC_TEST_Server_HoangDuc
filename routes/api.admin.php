<?php

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

Route::name('auth.')->group(function () {
    Route::post('auth/login', 'AuthenticationController@login')->name('login');
});

Route::middleware(['auth:users'])->group(function () {
    Route::get('foo', function () {
        return 'Hello World';
    });
});
