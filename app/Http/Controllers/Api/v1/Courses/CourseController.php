<?php

namespace App\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\BaseApiController;
use App\Http\Resources\Api\V1\Courses\indexCourseResource;
use App\Http\Resources\Api\V1\Courses\ShowCourseResourse;
use App\Models\Courses\Course;

class CourseController extends BaseApiController
{

    public function index(Course $course)
    {
       $courses = IndexCourseResource::collection($course->with([
           'categories' ,
           'categories.parent' ,
           'categories.children' ,
           'media' ,

       ])->get());  ;


      return  $this->apiResponse('200' , 'لیست همه دوره ها' , $courses ) ;
    }



    public function show(string $slug , Course $course)
    {
        $show = $course->where('slug' , $slug)
            ->with(['categories' , 'categories.parent' , 'categories.children' , 'media'])
        ->first();
        $course = ShowCourseResourse::make($show); ;
        if (! $show ) {
            return $this->apiResponse('404');
        }
        return $this->apiResponse('200' , '' , $course);
    }

}
