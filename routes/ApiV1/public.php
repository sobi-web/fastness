<?php


use App\Http\Controllers\Api\v1\Courses\CommentController;
use App\Http\Controllers\Api\v1\Courses\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/courses', [CourseController::class, 'index']);

Route::prefix('courses')->group(function () {

    Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');

    Route::post('/{slug}/comment', [CommentController::class, 'store'])->name('course.comment.store')->middleware('auth:sanctum');
    Route::get('/{slug}/comments', [CommentController::class, 'index'])->name('course.comment.index');
});

