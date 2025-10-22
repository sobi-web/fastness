<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Auth\AuthenticatedController;
use App\Http\Controllers\Api\v1\Auth\OtpController;
use App\Http\Controllers\Api\v1\Auth\RegisteredUserController;
use App\Services\SmsService;
use Illuminate\Support\Facades\Route;









Route::post('otp/request' , [OtpController::class , 'send'])->name('otp.request')->middleware('guest');

Route::post('otp/verify' , [AuthController::class , 'verifyOtp'])->name('auth.verify')->middleware('guest');


//Route::get('test' , function(){
//    $sms = new SmsService('09377346488');
//
//    // فراخوانی متد sendOTP()
//    $result = $sms->sendOTP('123456');
//});




//Route::post('/register', [RegisteredUserController::class, 'store'])
//    ->middleware('guest')
//    ->name('register');

//Route::post('/login', [AuthenticatedController::class, 'store'])
//    ->middleware('guest')
//    ->name('login');

//Route::post('/logout', [AuthenticatedController::class, 'destroy'])
//    ->middleware('auth')
//    ->name('logout');

//Route::post('/otp-verify' , [OtpController::class, 'verif'])->name('otp.verify');



//Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//    ->middleware('guest')
//    ->name('password.email');
//
//Route::post('/reset-password', [NewPasswordController::class, 'store'])
//    ->middleware('guest')
//    ->name('password.store');
//
//Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
//    ->middleware(['auth', 'signed', 'throttle:6,1'])
//    ->name('verification.verify');
//
//Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//    ->middleware(['auth', 'throttle:6,1'])
//    ->name('verification.send');

