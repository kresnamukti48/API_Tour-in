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
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->middleware('guest')->name('password.request');

    Route::get('/auth/reset/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');
});

Route::prefix('auth')->group(function () {
    Route::get('read', 'AuthController@index');
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forgot', 'AuthController@forgot')->middleware('guest')->name('password.email');
    Route::post('reset', 'AuthController@reset')->middleware('guest')->name('password.update');
});

Route::prefix('tour')->group(function () {
    Route::get('read', 'TourController@index');
    Route::post('create', 'TourController@store');
    Route::put('/update/{id}', 'TourController@update');
    Route::delete('/delete/{id}', 'TourController@delete');
});

Route::prefix('virtualtour')->group(function () {
    Route::get('read', 'VirtualtourController@index');
    Route::post('create', 'VirtualtourController@store');
    Route::put('/update/{id}', 'VirtualtourController@update');
    Route::delete('/delete/{id}', 'VirtualtourController@delete');
});

Route::prefix('virtualtourgallery')->group(function () {
    Route::get('read', 'VirtualtourgalleryController@index');
    Route::post('create', 'VirtualtourgalleryController@store');
    Route::put('/update/{id}', 'VirtualtourgalleryController@update');
    Route::delete('/delete/{id}', 'VirtualtourgalleryController@delete');
});
