<?php

namespace App\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Courses\CommentRequest;
use App\Http\Resources\Api\V1\Courses\CourseCommentResource;
use App\Http\Traits\Api\V1\ApiResponse;
use App\Models\Scopes\Courses\ActiveCommentScope;
use App\Models\Shop\Course\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CourseCommentController extends Controller
{
    use ApiResponse;

    public function index($slug, Course $course)
    {
        try {

            $course = $course->where('slug', $slug)->with(['comments', 'comments.user'])->firstOrFail();
            $Comments_result = $course->comments;
            $comments = CourseCommentResource::collection($Comments_result);

            return $this->successResponse($comments);

        } catch (Throwable $e) {
            \Log::error('ShowComment Error 500: ' . $e->getMessage());

            return $this->errorResponse(
                ['error' => $e->getMessage()],
                'خطای داخلی سرور',
                500
            );

        }

    }

    public function store(string $slug, CommentRequest $request)
    {
        try {
            $user_id = auth()->id();

            // پیدا کردن دوره، اگر نباشه → 404
            $current_course = Course::where('slug', $slug)
                ->with(['comments', 'comments.user'])
                ->first();

            // بررسی وجود کامنت قبلی بدون محدودیت active scope
            $user_comment = $current_course->comments()
                ->withoutGlobalScope(ActiveCommentScope::class)
                ->where('user_id', $user_id)
                ->first();


            if ($user_comment) {
                return $this->errorResponse(
                    CourseCommentResource::make($user_comment) ,
                    'شما قبلا برای این دوره نظر ثبت کرده اید',
                    409
                );
            }

            // ساخت کامنت جدید
            $comment = $current_course->comments()->create([
                'user_id' => $user_id,
                'body' => $request->body,
                'rating' => $request->rating,
                'status' => 1,
            ]);

            // ساخت خروجی Resource
            $stored_comment = CourseCommentResource::make($comment);

//            return $this->apiResponse(200, 'کامنت شما با موفقیت ثبت شد', $stored_comment);
            return $this->successResponse($stored_comment);

        }  catch (Throwable $e) {
            \Log::error('StoreComment Error: 500  ' . $e->getMessage());

            // هر خطای غیرمنتظره دیگر
            return $this->errorResponse($e->getMessage(), 'خطای داخلی سرور', 500);

        }


    }
}
