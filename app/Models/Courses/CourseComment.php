<?php

namespace App\Models\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    use HasFactory;
   protected $fillable = [
       'course_id',
       'user_id',
       'body',
       'rating' ,
       'status'

   ];

   public function user() {
       return $this->belongsTo('App\Models\User');
   }
   public function course() {
       return $this->belongsTo('App\Models\Courses\Course');
   }
}
