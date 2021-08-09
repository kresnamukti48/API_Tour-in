<?php

use App\Models\Role;
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

Route::get('/', function () {
})->name('index');

Route::middleware(['json.response'])->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('admin')->middleware(['role:'.Role::ROLE_ADMIN])->namespace('Admin')->group(function () {
            Route::namespace('Payment')->group(function () {
                Route::get('payment-vendor/trashed', 'PaymentVendorController@trashed');
                Route::post('payment-vendor/{id}/restore', 'PaymentVendorController@restore');
                Route::apiResource('payment-vendor', 'PaymentVendorController')->except(['show'])->parameter('payment-vendor', 'paymentVendor');

                Route::get('payment-category/trashed', 'PaymentCategoryController@trashed');
                Route::post('payment-category/{id}/restore', 'PaymentCategoryController@restore');
                Route::apiResource('payment-category', 'PaymentCategoryController')->except(['show'])->parameter('payment-category', 'paymentCategory');

                Route::get('payment-method/trashed', 'PaymentVendorMethodController@trashed');
                Route::post('payment-method/{id}/restore', 'PaymentVendorMethodController@restore');
                Route::apiResource('payment-method', 'PaymentVendorMethodController')->except(['show'])->parameter('payment-method', 'paymentVendorMethod');

                Route::get('payment-channel/trashed', 'PaymentChannelsController@trashed');
                Route::post('payment-channel/{id}/restore', 'PaymentChannelsController@restore');
                Route::apiResource('payment-channel', 'PaymentChannelsController')->except(['show'])->parameter('payment-channel', 'paymentChannels');
            });
        });

        Route::prefix('tourmanager')->middleware(['role:'.Role::ROLE_TOUR_MANAGER])->namespace('TourManager')->group(function () {
            Route::apiResource('tour', 'TourController');
        });

        Route::prefix('user')->group(function () {
            Route::get('profile', 'UserController@profile');
        });

        Route::middleware(['role:'.Role::ROLE_USER])->group(function () {
            Route::apiResource('order-ticket', 'OrderTicketController');
            Route::apiResource('order-souvenir', 'OrderSouvenirController');
        });
    });

    Route::prefix('auth')->group(function () {
        Route::get('read', 'AuthController@index');
        Route::post('register', 'AuthController@register');
        Route::post('register_seller', 'AuthController@register_seller');
        Route::post('register_manager', 'AuthController@register_manager');
        Route::post('login', 'AuthController@login');
        Route::post('forgot', 'AuthController@forgot')->middleware('guest')->name('password.email');

        Route::get('/reset/{token}', function ($token) {
            return view('auth.reset-password', ['token' => $token]);
        })->middleware('guest')->name('password.reset');
        Route::post('reset', 'AuthController@reset')->middleware(['guest'])->name('password.update');

        Route::get('/social/{social}/redirect', 'AuthController@authSocial');
        Route::get('/social/{social}/callback', 'AuthController@authSocialCallback');
    });

    Route::apiResource('tour', 'TourController');

    Route::apiResource('virtualtour', 'VirtualTourController');

    Route::apiResource('virtualtourgallery', 'VirtualTourGalleryController');

    Route::apiResource('store', 'StoreController');

    Route::apiResource('ticket', 'TicketController');

    Route::apiResource('souvenir', 'SouvenirController');

    Route::apiResource('souvenirstock', 'SouvenirStockController');

    Route::apiResource('review', 'ReviewController');

    Route::prefix('status')->group(function () {
        Route::get('{trxid}', 'StatusController@index')->name('status');
        Route::any('{vendor}/{trxid?}', 'StatusController@callback');
    });
});
