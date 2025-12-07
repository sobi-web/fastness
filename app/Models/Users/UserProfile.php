<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        'avatar_url',
        'gender',
        'birth_date',
        'bio' ,
        'job_title',

    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }




}
