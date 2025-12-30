<?php

namespace App\Models\User;

use App\Enums\Api\V1\UserProfileGender;
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
    protected $casts = [
        'birth_date' => 'date',
        'gender' => UserProfileGender::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }




}
