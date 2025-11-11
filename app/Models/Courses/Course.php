<?php

namespace App\Models\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    public function categories()
    {
        return $this->belongsToMany(
            CourseCategory::class,
            'course_category_course', // نام جدول pivot
            'course_id',              // کلید خارجی در pivot برای Course
            'course_category_id'      // کلید خارجی در pivot برای Category
        );    }

    // 🧩 فازهای دوره
    public function phases()
    {
        return $this->hasMany(Phase::class);
    }

    // 🎬 فایل‌های چندرسانه‌ای دوره
    public function media()
    {
        return $this->hasMany(CourseMedia::class);
    }
}
