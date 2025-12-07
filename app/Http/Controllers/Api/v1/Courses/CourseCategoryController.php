<?php

namespace App\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Courses\CategoryResource;
use App\Http\Resources\Api\V1\Courses\IndexCourseResource;
use App\Http\Traits\Api\V1\ApiResponse;
use App\Models\Courses\CourseCategory;

class CourseCategoryController extends Controller
{
  use ApiResponse ;
    public function index(CourseCategory $category)
    {
        $categories = $category
            ->withCount('courses')
            ->whereNull('parent_id')
            ->get();
        $resourse = CategoryResource::collection($categories);

        return $this->successResponse($resourse);
    }

    public function show(CourseCategory $coursecategory)
    {
        $categories = $coursecategory->load('parent', 'childrenRecursive' , 'courses');

        $resourse = CategoryResource::make($categories);

        return $this->successResponse($resourse);

    }


    public function Courses(CourseCategory $coursecategory)
    {
        $courses = $coursecategory->courses->load('comments',  'media' ,'categories');

        $resourse = IndexCourseResource::collection($courses);
        return $this->successResponse($resourse);
    }


}
