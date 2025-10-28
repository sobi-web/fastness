<?php

use App\Http\Controllers\Api\v1\Dashboard\ProfieController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
   Route::post('/profile' , [ProfieController::class , 'store']);
    Route::put('/profile' , [ProfieController::class , 'update']);
    Route::get('/profile' , [ProfieController::class , 'show']);
    Route::get('/test' , [ProfieController::class , 'test']);


});
