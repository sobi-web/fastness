<?php

namespace App\Models\Courses;

use App\Enums\Api\V1\CourseCommentStatus;
use App\Models\Scopes\Courses\ActiveCommentScope;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([ActiveCommentScope::class])]
class CourseComment extends Model
{
    use HasFactory;
  protected $casts = [
      'status' => CourseCommentStatus::class,
  ];
    protected $fillable = [
        'course_id',
        'user_id',
        'body',
        'rating',
        'status'

    ];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
