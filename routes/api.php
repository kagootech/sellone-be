<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\VariantController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
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


Route::domain(env('API_DOMAIN'))->group(function () {

    Route::prefix('product')->group(function () {
        Route::get('', [ProductController::class, 'index']);
        Route::get('/{state}/view', [ProductController::class, 'show']);
    });

    // Must auth
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/image', [ImageController::class, 'store']);
        // Route::prefix('order')->group(function () {
        //     Route::post('/charge', [OrderController::class, 'charge']);
        // });

        Route::prefix('wishlist')->group(function(){
            Route::get('/', [WishlistController::class, 'index']);
            Route::post('/store', [WishlistController::class, 'store']);
        });

        // Route for manage shop (CRUD product/Order am)
        Route::prefix('mng-shop')->group(function () {

            Route::post('/register', [ShopController::class, 'store']);

            Route::prefix('product')->group(function () {
                Route::post('/store', [ShopProductController::class, 'store']);
                Route::post('{id}/update', [ShopProductController::class, 'update']);
                Route::post('{id}/delete', [ShopProductController::class, 'delete']);
            });

            Route::prefix('variant')->group(function () {
                Route::post('', [VariantController::class, 'store']);
                Route::post('/{id}/update', [VariantController::class, 'update']);
                Route::post('/{id}/delete', [VariantController::class, 'delete']);
            });
        });
    });
});
