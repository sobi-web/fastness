<?php

namespace App\Models\Shop\Coupon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\Coupon\CouponFactory> */
    use HasFactory;

    protected $fillable = [
        'is_global',
        'is_active',
        'starts_at',
        'expires_at',
        'max_per_user',
        'max_uses',
        'used_count',
        'code',
        'discount_value' ,
        'discount_type'
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'max_per_user' => 'integer',
        'max_uses' => 'integer',
        'used_count' => 'integer',
    ];

    /* ========================
       Relations
    ========================= */

    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_users')
            ->withPivot('use_count')
            ->withTimestamps();
    }

    /* ========================
       Validation
    ========================= */

    public function isValidNow(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function canBeUsed(): bool
    {
        if ($this->max_uses === null) {
            return true;
        }

        return $this->used_count < $this->max_uses;
    }

    public function canBeUsedByUser(int $userId): bool
    {
        if ($this->max_per_user === null) {
            return true;
        }

        $used = \DB::table('coupon_users')
            ->where('coupon_id', $this->id)
            ->where('user_id', $userId)
            ->value('use_count') ?? 0;

        return $used < $this->max_per_user;
    }

    /* ========================
       Discount Calculation
    ========================= */

    public function discountFor(int $amount): int
    {
        return match ($this->discount_type) {
            'percent' => (int)floor($amount * $this->discount_value / 100),
            'amount' => min($this->discount_value, $amount),
        };
    }
}
