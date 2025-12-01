<?php

namespace App\Models\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CourseCategory extends Model
{
    /** @use HasFactory<\Database\Factories\Courses\CourseCategoryFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];

    /* ---------------- Relations ---------------- */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    // 🔁 دسته‌های فرزند
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // 🔁 دسته والد

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    // 🧠 دوره‌های این دسته
    public function courses() : BelongsToMany
    {
        return $this->belongsToMany(
            Course::class,
            'course_category_course',
            'course_category_id',
            'course_id'
        );    }
}
