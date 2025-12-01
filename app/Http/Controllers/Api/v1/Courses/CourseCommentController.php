<?php

namespace App\Http\Controllers\Api\v1\Courses;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Api\V1\Courses\CommentRequest;
use App\Http\Resources\Api\V1\Courses\CourseCommentResource;
use App\Models\Courses\Course;
use App\Models\Scopes\Courses\ActiveCommentScope;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Throwable;

class CourseCommentController extends BaseApiController
{
    public function index($slug, Course $course)
    {
        try {

            $course = $course->where('slug', $slug)->with(['comments', 'comments.user'])->firstOrFail();
            $Comments_result = $course->comments;
            $comments = CourseCommentResource::collection($Comments_result);

            return $this->apiResponse(200, 'کامنت های دوره ', $comments);

        } catch (ModelNotFoundException $e) {

            // وقتی دوره با slug پیدا نشد
            return $this->apiResponse(404, 'دوره مورد نظر یافت نشد.');

        } catch (Throwable $e) {
            \Log::error('ShowComment Error: '.$e->getMessage());

            // هر خطای غیرمنتظره دیگر
            return $this->apiResponse(500, 'خطای داخلی سرور', [
                'error' => $e->getMessage()
            ]);
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
                return $this->apiResponse(409, 'شما قبلا برای این دوره نظر ثبت کرده‌اید.', CourseCommentResource::make($user_comment));
            }

            // ساخت کامنت جدید
            $comment = $current_course->comments()->create([
                'user_id' => $user_id,
                'body' => $request->body,
                'rating' => $request->rating,
                'status' => 1 ,
            ]);

            // ساخت خروجی Resource
            $stored_comment = CourseCommentResource::make($comment);

            return $this->apiResponse(200, 'کامنت شما با موفقیت ثبت شد', $stored_comment);

        } catch (ModelNotFoundException $e) {

            // وقتی دوره با slug پیدا نشد
            return $this->apiResponse(404, 'دوره مورد نظر یافت نشد.' ,
            [
                'error' => $e->getMessage()
            ]
            );

        } catch (Throwable $e) {
            \Log::error('StoreComment Error: '.$e->getMessage());

            // هر خطای غیرمنتظره دیگر
            return $this->apiResponse(500, 'خطای داخلی سرور', [
                'error' => $e->getMessage()
            ]);
        }


    }
}
