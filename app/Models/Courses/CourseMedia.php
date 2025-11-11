<?php

namespace App\Models\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMedia extends Model
{
    /** @use HasFactory<\Database\Factories\Courses\CourseMediaFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'type',       // image | video | voice | pdf
        'path',  // مسیر فایل در storage
        'caption',    // توضیح اختیاری برای فایل
    ];

    /* ---------------- Relations ---------------- */

    // 🔗 به دوره مربوط است
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // 🔗 ممکن است به یک فاز خاص مربوط باشد


}
