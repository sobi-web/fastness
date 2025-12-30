<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Api\V1\UserRole;
use App\Models\Shop\Course\CourseComment;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable , HasFactory , HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'phone',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * //     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {

      return $this->role === UserRole::ADMIN ;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function getAuthIdentifierName()
    {
        return 'phone'; // بجای email
    }

    public static function findByPhone(string $phone)
    {
        return User::where('phone', $phone)->first();
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }
    public function getNameAttribute()
    {
        return $this->profile?->full_name ?? 'ناشناس';
    }

    public function isProfileCompleted(): bool
    {
        $profile = $this->profile;
        return $profile
            && $profile->full_name
            && $profile->job_title
            && $profile->gender
            && $profile->birth_date;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CourseComment::class, 'user_id', 'id');
    }




}
