<?php

namespace App\Services\Shop;

use App\Models\Shop\Cart\Cart;
use App\Models\Shop\Coupon\Coupon;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CouponService
{
    public function findValid(string $code, User $user): Coupon
    {
        $coupon = Coupon::where('code', $code)
            ->lockForUpdate()
            ->firstOrFail();

        if (! $coupon->is_active) {
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
    }

    public function calculateDiscount(Coupon $coupon, Cart $cart): array
    {
        $itemDiscounts = [];
        $totalDiscount = 0;

        if ($coupon->course_id) {
            $item = $cart->items
                ->firstWhere('course_id', $coupon->course_id);

            if (! $item) {
                throw ValidationException::withMessages([
                    'coupon' => 'Coupon not applicable',
                ]);
            }

            $totalDiscount = $this->discountFor(
                $coupon,
                $item->unit_price * $item->quantity
            );

            $itemDiscounts[$item->course_id] = $totalDiscount;
        } else {
            $subtotal = $cart->items->sum(
                fn ($i) => $i->unit_price * $i->quantity
            );

            $totalDiscount = $this->discountFor($coupon, $subtotal);
        }

        return [
            'total' => $totalDiscount,
            'items' => $itemDiscounts,
        ];
    }

    public function consume(Coupon $coupon, User $user): void
    {
        DB::transaction(function () use ($coupon, $user) {

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

    protected function discountFor(Coupon $coupon, int $amount): int
    {
        return match ($coupon->discount_type) {
            'percent' => (int) floor($amount * $coupon->discount_value / 100),
            'amount'  => min($coupon->discount_value, $amount),
        };
    }
}
