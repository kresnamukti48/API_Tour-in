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
            Route::prefix('tour')->group(function () {
                Route::post('export', 'TourController@export');
            });

            Route::prefix('virtualtour')->group(function () {
                Route::post('export', 'VirtualTourController@export');
            });

            Route::prefix('ticket')->group(function () {
                Route::post('export', 'TicketController@export');
            });

            Route::prefix('seller')->group(function () {
                Route::post('export', 'SellerController@export');
            });

            Route::prefix('store')->group(function () {
                Route::post('export', 'StoreController@export');
            });

            Route::prefix('souvenir')->group(function () {
                Route::post('export', 'SouvenirController@export');
            });

            Route::apiResource('tour', 'TourController');

            Route::apiResource('virtualtour', 'VirtualTourController');
            Route::apiResource('ticket', 'TicketController');
            Route::apiResource('seller', 'SellerController');
            Route::apiResource('store', 'StoreController');
            Route::apiResource('souvenir', 'SouvenirController');
        });

        Route::prefix('seller')->middleware(['role:'.Role::ROLE_SELLER])->namespace('Seller')->group(function () {
            Route::prefix('souvenir')->group(function () {
                Route::post('export', 'SouvenirController@export');
            });

            Route::prefix('store')->group(function () {
                Route::post('export', 'StoreController@export');
            });

            Route::prefix('souvenirstock')->group(function () {
                Route::post('export', 'SouvenirStockController@export');
            });

            Route::prefix('souvenirstock')->group(function () {
                Route::post('import', 'SouvenirStockController@import');
            });

            Route::apiResource('store', 'StoreController');
            Route::apiResource('souvenir', 'SouvenirController');
            Route::apiResource('souvenirstock', 'SouvenirStockController');
        });

        Route::prefix('user')->group(function () {
            Route::get('profile', 'UserController@profile');
        });

        Route::middleware(['role:'.Role::ROLE_USER])->group(function () {
            Route::apiResource('order-ticket', 'OrderTicketController')->only(['index', 'store']);
            Route::apiResource('order-souvenir', 'OrderSouvenirController')->only(['index', 'store']);
        });
    });

    Route::prefix('auth')->group(function () {
        Route::get('read', 'AuthController@index');
        Route::post('register', 'AuthController@register');
        Route::post('register_seller', 'AuthController@register_seller');
        Route::post('register_manager', 'AuthController@register_manager');
        Route::post('login', 'AuthController@login');
        Route::post('forgot', 'AuthController@forgot')->middleware('guest')->name('password.email');

        Route::post('reset', 'AuthController@reset')->middleware(['guest'])->name('password.update');

        Route::get('/social/{social}/redirect', 'AuthController@authSocial');
        Route::get('/social/{social}/callback', 'AuthController@authSocialCallback');
    });

    Route::apiResource('tour', 'TourController')->only(['index']);

    Route::apiResource('virtualtour', 'VirtualTourController')->only(['index']);

    Route::apiResource('virtualtourgallery', 'VirtualTourGalleryController')->only(['index']);

    Route::apiResource('store', 'StoreController')->only(['index']);

    Route::apiResource('ticket', 'TicketController')->only(['index']);

    Route::apiResource('souvenir', 'SouvenirController')->only(['index']);

    Route::apiResource('souvenirstock', 'SouvenirStockController')->only(['index']);

    Route::apiResource('review', 'ReviewController')->only(['store', 'show']);

    Route::prefix('status')->group(function () {
        Route::get('{trxid}', 'StatusController@status')->name('status');
        Route::any('{vendor}/{trxid?}', 'StatusController@callback');
    });
});
