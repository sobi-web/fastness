<?php

use App\Http\Controllers\Api\v1\Courses\CourseController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // مسیرهایی که نیاز به لاگین ندارند:
    Route::prefix('auth')->group(base_path('routes/ApiV1/auth.php'));

    Route::prefix('dashboard')->group(base_path('routes/ApiV1/dashboard.php'))->middleware('auth:sanctum');

    require base_path('routes/ApiV1/course.php');
    require base_path('routes/ApiV1/cart.php');


});
