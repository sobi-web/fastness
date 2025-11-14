<?php

namespace App\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\BaseApiController;
use App\Models\Courses\Course;
use Illuminate\Http\Request;

class CourseCommentController extends BaseApiController
{
    public function index($slug, Course $course) {

        $course = $course->where('slug', $slug)->firstOrFail();


        if (! $course ) {
            return $this->apiResponse(404 , 'course not found');
        }

        $comments = $course->comments;

        return $this->apiResponse(200 , 'کامنت های دوره ' , $comments);

    }
    public function store(Request $request) {

    }
}
