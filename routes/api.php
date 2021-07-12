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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('profile', 'UserController@profile');
    });
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
});

Route::prefix('tour')->group(function () {
    Route::get('read', 'TourController@index');
    Route::post('create', 'TourController@store');
    Route::put('/update/{id}', 'TourController@update');
    Route::delete('/delete/{id}', 'TourController@delete');
});
