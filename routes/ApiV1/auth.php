<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Auth\OtpController;
use Illuminate\Support\Facades\Route;


Route::post('otp/request', [OtpController::class, 'send'])->name('otp.request')->middleware('guest');

Route::post('verify', [AuthController::class, 'verifyOtp'])->name('auth.verify')->middleware('guest');

Route::delete('logout' , [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
