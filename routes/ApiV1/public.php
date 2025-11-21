<?php


use App\Http\Controllers\Api\v1\Courses\CourseCommentController;
use App\Http\Controllers\Api\v1\Courses\CourseController;
use Illuminate\Support\Facades\Route ;

Route::get('/courses' , [CourseController::class, 'index']);
Route::get('/courses/{slug}' , [CourseController::class, 'show']);

Route::post('/courses/{slug}/comment' , [CourseCommentController::class, 'store']);
Route::get('/courses/{slug}/comments' , [CourseCommentController::class, 'index']);
