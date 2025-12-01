<?php

namespace App\Http\Controllers\app\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Courses\CategoryResource;
use App\Http\Resources\Api\V1\Courses\IndexCourseResource;
use App\Models\Courses\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends BaseApiController
{

    public function index(CourseCategory $category)
    {
        $categories = $category
            ->withCount('courses')
            ->whereNull('parent_id')
            ->get();
        $resourse = CategoryResource::collection($categories);

        return $this->apiResponse(200, 'دسته های اصلی با موفقیت دریافت شد', $resourse);
    }

    public function show(CourseCategory $coursecategory)
    {
        $categories = $coursecategory->load('parent', 'childrenRecursive' , 'courses');

        $resourse = CategoryResource::make($categories);

        return $this->apiResponse(200, '', $resourse);

    }


    public function Courses(CourseCategory $coursecategory)
    {
        $courses = $coursecategory->courses->load('comments',  'media' ,'categories');

        $resourse = IndexCourseResource::collection($courses);
        return $this->apiResponse(200, 'دوره های دسته بندی مورد نظر با موفقیت دریافت شد', $resourse);
    }


}
