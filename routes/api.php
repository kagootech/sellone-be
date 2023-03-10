<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;
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


Route::domain('api.sellone.shop')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/user', function (Request $request) {
            return $request->user()->get(['name','email']);
        });

        Route::prefix('product')->group(function(){

        });

        Route::prefix('order')->group(function(){
            Route::post('/charge', [OrderController::class, 'charge']);
        });
    });
});