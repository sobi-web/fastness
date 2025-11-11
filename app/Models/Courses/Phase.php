<?php

namespace App\Models\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    /** @use HasFactory<\Database\Factories\Courses\PhaseFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'description',
        'order',
        'duration_days',
    ];

    /* ---------------- Relations ---------------- */

    // 🧠 فاز به یک دوره مربوط است
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // 🎬 فایل‌های چندرسانه‌ای مخصوص این فاز (در آینده NutritionPackage)
    public function media()
    {
        return $this->hasMany(CourseMedia::class);
    }
}
