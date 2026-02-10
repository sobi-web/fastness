<?php

use App\Http\Controllers\Api\v1\Cart\CartController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {

    Route::get('/cart', [CartController::class, 'show']);

    Route::post('/cart/items', [CartController::class, 'add']);

    Route::delete('/cart/items', [CartController::class, 'remove']);

    Route::post('/cart/coupon', [CartController::class, 'applyCoupon']);

    Route::delete('/cart/coupon', [CartController::class, 'removeCoupon']);

});
