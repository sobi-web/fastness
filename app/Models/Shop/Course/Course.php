<?php

namespace App\Models\Shop\Course;

use App\Models\Scopes\Courses\ActiveScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([ActiveScope::class])]

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\Course\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price'
    ];

    /* ---------------- Relations ---------------- */

    public function categories(): BelongsToMany
    {


        return $this->belongsToMany(CourseCategory::class, 'course_category_course', 'course_id', 'course_category_id');
    }


    public function phases() : HasMany
    {
        return $this->hasMany(Phase::class);
    }


    public function media() : HasMany
    {
        return $this->hasMany(CourseMedia::class);
    }


    public function comments() : HasMany
    {
        return $this->hasMany(CourseComment::class , 'course_id', 'id');
    }


}
