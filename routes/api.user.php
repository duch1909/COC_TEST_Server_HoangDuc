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

Route::post('course-registrations', 'CourseRegistrationController@store');
Route::get('/course-registrations/{course_registration}', 'CourseRegistrationController@show')->middleware('auth.custom:users');
Route::post('/send-token', 'CourseRegistrationController@sendToken');

Route::middleware(['auth:users'])->group(function () {
    Route::apiResource('course-registrations', 'CourseRegistrationController')->only('update', 'destroy', 'index');
});
