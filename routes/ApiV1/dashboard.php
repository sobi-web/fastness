<?php

use App\Http\Controllers\Api\v1\Dashboard\ProfileController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile' , [ProfileController::class , 'show']);
    Route::post('/profile' , [ProfileController::class , 'store']);
    Route::put('/profile' , [ProfileController::class , 'update']);


});
