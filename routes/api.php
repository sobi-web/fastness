<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::prefix('v1')->middleware('json')->group(function () {






    Route::prefix('auth')->group(base_path('routes/ApiV1/auth.php'))->middleware('guest');


});
