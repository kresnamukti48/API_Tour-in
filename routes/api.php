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

Route::middleware(['json.response'])->group(function () {
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

    Route::apiResource('tour', 'TourController');

    Route::apiResource('virtualtour', 'VirtualTourController');

    Route::apiResource('virtualtourgallery', 'VirtualTourGalleryController');

    Route::apiResource('store', 'StoreController');

    Route::apiResource('ticket', 'TicketController');

    Route::apiResource('souvenir', 'SouvenirController');

    Route::apiResource('souvenirstock', 'SouvenirStockController');
});
