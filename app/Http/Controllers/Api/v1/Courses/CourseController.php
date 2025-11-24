<?php

namespace App\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\BaseApiController;
use App\Http\Resources\Api\V1\Courses\indexCourseResource;
use App\Http\Resources\Api\V1\Courses\ShowCourseResourse;
use App\Models\Courses\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CourseController extends BaseApiController
{

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


            return $this->apiResponse('200', 'لیست همه دوره ها', $courses);
        } catch (Throwable $e) {

            \Log::error('CourseIndex Error: '.$e->getMessage());

            // اگر خطای غیرمنتظره پیش بیاد
        return $this->apiResponse(500, 'خطای داخلی سرور', [
            'error' => app()->environment('local')
                ? $e->getMessage() // در حالت local پیام اصلی خطا رو نشون بده
                : null
        ]);
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

            return $this->apiResponse('200', 'دوره مورد نظر شما با موفقیت دریافت شد', $course);

        } catch (ModelNotFoundException $e) {

            // وقتی دوره با slug پیدا نشد
            return $this->apiResponse(404, 'دوره مورد نظر یافت نشد.');

        } catch (Throwable $e) {
            \Log::error('CourseShow Error: '.$e->getMessage());

            // هر خطای غیرمنتظره دیگر
            return $this->apiResponse(500, 'خطای داخلی سرور', [
                'error' => $e->getMessage()
            ]);
        }
    }

}
