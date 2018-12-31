<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {
    // define api endpoints for all users
    Route::middleware(['auth:api', 'role:teacher|student|admin'])->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    // define api endpoints for teacher
//    Route::middleware(['auth:api', 'role:teacher'])->namespace('Teacher')->group(function () {
//    });

    // define api endpoints for student
//    Route::middleware(['auth:api', 'role:student'])->namespace('Student')->group(function () {
//    });

    // define none authentication api
    Route::namespace('Teacher')->group(function () {
        Route::post('/teachers', 'TeacherController@create');
    });

    Route::namespace('Student')->group(function () {
        Route::post('/students', 'StudentController@create');
    });

});
