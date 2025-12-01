<?php


use App\Http\Controllers\Api\v1\Courses\CourseCommentController;
use App\Http\Controllers\Api\v1\Courses\CourseController;
use App\Http\Controllers\app\Http\Controllers\Api\v1\Courses\CourseCategoryController;
use Illuminate\Support\Facades\Route;


Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index']);


    Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');

    Route::post('/{slug}/comment', [CourseCommentController::class, 'store'])->name('course.comment.store')->middleware('auth:sanctum');
    Route::get('/{slug}/comments', [CourseCommentController::class, 'index'])->name('course.comment.index');
});


Route::prefix('course-category')->group(function () {
    Route::get('/', [CourseCategoryController::class, 'index'])->name('course.category.index');


    Route::get('/{coursecategory:slug}', [CourseCategoryController::class, 'show'])->name('courses.category.show');

    Route::get('/{coursecategory:slug}/courses', [CourseCategoryController::class, 'courses'])->name('courses.incategoty.show');


});
