<?php

namespace App\Models\Courses;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
//        return $this->belongsToMany(
//            CourseCategory::class,
//            'course_category_course', // نام جدول pivot
//            'course_id',              // کلید خارجی در pivot برای Course
//            'course_category_id'      // کلید خارجی در pivot برای Category
//        );

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

    public function activeCourses()
    {
        return $this->where('is_active', CourseStatus::ACTIVE)->get();
    }

    public function comments() : BelongsTo
    {
        return $this->hasMany(CourseComment::class);
    }

}
