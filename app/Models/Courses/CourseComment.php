<?php

namespace App\Models\Courses;

use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
   protected $fillable = [
       'course_id',
       'user_id',
       'body',
       'rate'

   ];

   public function user() {
       return $this->belongsTo('App\Models\User');
   }
   public function course() {
       return $this->belongsTo('App\Models\Courses\Course');
   }
}
