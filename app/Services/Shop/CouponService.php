<?php

namespace App\Services\Shop;

use App\Models\Shop\Cart\Cart;
use App\Models\Shop\Coupon\Coupon;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CouponService
{
    /* ================= VALIDATION ================= */

    public function findValid(string $code, User $user): Coupon
    {
        return DB::transaction(function () use ($code, $user) {

            $coupon = Coupon::where('code', $code)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$coupon->is_active) {
                throw ValidationException::withMessages([
                    'coupon' => 'Coupon inactive',
                ]);
            }

            if ($coupon->starts_at && $coupon->starts_at->isFuture()) {
                throw ValidationException::withMessages([
                    'coupon' => 'Coupon not started',
                ]);
            }

            if ($coupon->expires_at && $coupon->expires_at->isPast()) {
                throw ValidationException::withMessages([
                    'coupon' => 'Coupon expired',
                ]);
            }

            if ($coupon->max_uses !== null &&
                $coupon->used_count >= $coupon->max_uses) {
                throw ValidationException::withMessages([
                    'coupon' => 'Coupon usage limit reached',
                ]);
            }

            if ($coupon->max_per_user !== null) {
                $used = DB::table('coupon_users')
                    ->where('coupon_id', $coupon->id)
                    ->where('user_id', $user->id)
                    ->value('use_count') ?? 0;

                if ($used >= $coupon->max_per_user) {
                    throw ValidationException::withMessages([
                        'coupon' => 'Coupon usage per user exceeded',
                    ]);
                }
            }

            return $coupon;
        });
    }

    /* ================= CALCULATION ================= */

    public function calculate(Coupon $coupon, Cart $cart): int
    {
        $cart->load('items');

        $subtotal = $cart->items->sum('final_price');

        if ($subtotal <= 0) {
            return 0;
        }

        return match ($coupon->discount_type) {
            'percent' => min(
                (int) round($subtotal * ($coupon->discount_value / 100)),
                $subtotal
            ),
            'amount' => min($coupon->discount_value, $subtotal),
            default => 0,
        };
    }

    /* ================= CONSUME ================= */

    public function consume(Coupon $coupon, User $user): void
    {
        DB::transaction(function () use ($coupon, $user) {

            if ($coupon->max_per_user !== null) {
                $used = DB::table('coupon_users')
                    ->where('coupon_id', $coupon->id)
                    ->where('user_id', $user->id)
                    ->lockForUpdate()
                    ->value('use_count') ?? 0;

                if ($used >= $coupon->max_per_user) {
                    throw ValidationException::withMessages([
                        'coupon' => 'Coupon usage per user exceeded',
                    ]);
                }
            }

            if ($coupon->max_uses !== null &&
                $coupon->used_count >= $coupon->max_uses) {
                throw ValidationException::withMessages([
                    'coupon' => 'Coupon usage limit reached',
                ]);
            }

            $coupon->increment('used_count');

            DB::table('coupon_users')->updateOrInsert(
                [
                    'coupon_id' => $coupon->id,
                    'user_id' => $user->id,
                ],
                [
                    'use_count' => DB::raw('use_count + 1'),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        });
    }
}
