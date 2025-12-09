<?php

namespace App\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Courses\indexCourseResource;
use App\Http\Resources\Api\V1\Courses\ShowCourseResourse;
use App\Http\Traits\Api\V1\ApiResponse;
use App\Models\Shop\Course\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CourseController extends Controller
{
    use ApiResponse;

    public function index(Course $course)
    {
        try {


            $courses = IndexCourseResource::collection($course->with([
                'categories',
                'categories.parent',
                'categories.children',
                'media',

            ])
                ->withCount('comments')
                ->withAvg('comments', 'rating')
                ->get());;


            return $this->successResponse($courses, 'لیست همه دوره ها');

        } catch (Throwable $e) {

            \Log::error('CourseIndex Error: 500 ' . $e->getMessage());

            // اگر خطای غیرمنتظره پیش بیاد
            return $this->errorResponse([
                app()->environment('local')
                    ? $e->getMessage() // در حالت local پیام اصلی خطا رو نشون بده
                    : null
            ], 'خطای داخلی سرور', 500);
        }
    }


    public function show(string $slug, Course $course)
    {
        try {


            $show = $course->where('slug', $slug)
                ->with(['categories', 'categories.parent', 'categories.children', 'media'])
                ->withCount('comments')
                ->withAvg('comments', 'rating')
                ->first();
            $course = ShowCourseResourse::make($show);;

            return $this->successResponse($course);

        } catch (ModelNotFoundException $e) {

            // وقتی دوره با slug پیدا نشد
//            return $this->apiResponse(404, 'دوره مورد نظر یافت نشد.');
            return $this->errorResponse($e->getMessage(), null ,  404);

        } catch (Throwable $e) {
            \Log::error('CourseShow Error: ' . $e->getMessage());

            // هر خطای غیرمنتظره دیگر
//            return $this->apiResponse(500, 'خطای داخلی سرور', [
//                'error' => $e->getMessage()
//            ]);
            return $this->errorResponse($e->getMessage(), 'خطای داخلی سرور' , 500);
        }
    }

}
