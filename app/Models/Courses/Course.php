<?php

namespace App\Models\Courses;

use App\Enums\Api\V1\CourseStatus;
use App\Models\Scopes\Courses\ActiveScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([ActiveScope::class])]

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Courses\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
    ];

    /* ---------------- Relations ---------------- */

    // 📁 دسته دوره
    public function categories(): BelongsToMany
    {


        return $this->belongsToMany(CourseCategory::class, 'course_category_course', 'course_id', 'course_category_id');
    }

    // 🧩 فازهای دوره
    public function phases() : HasMany
    {
        return $this->hasMany(Phase::class);
    }

    // 🎬 فایل‌های چندرسانه‌ای دوره
    public function media() : HasMany
    {
        return $this->hasMany(CourseMedia::class);
    }


    public function comments() : HasMany
    {
        return $this->hasMany(CourseComment::class , 'course_id', 'id');
    }

}
