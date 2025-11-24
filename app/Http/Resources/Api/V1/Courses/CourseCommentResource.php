<?php

namespace App\Http\Resources\Api\V1\Courses;

use App\Enums\Api\V1\CourseCommentStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->user->profile->full_name,
            'body' => $this->body ,
            'rating' => $this->rating . '/5',
            'created_at' => $this->created_at->diffForHumans(),
            'status' => $this->status instanceof CourseCommentStatus
        ? $this->status->name() // اگر Enum هست → label
        : CourseCommentStatus::from($this->status)->name(),
        ];
    }
}
