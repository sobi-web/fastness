<?php

namespace App\Services\Shop;

use App\Models\Shop\Cart\Cart;
use App\Models\Shop\Course\Course;

class CartService
{
    protected Cart $cart;

    public function __construct(?Cart $cart = null)
    {
        $this->cart = $cart ?? Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ]);
    }

    /* ========================
       Core getters
    ========================= */

    public function cart(): Cart
    {
        return $this->cart->load('items.course', 'coupon');
    }

    public function items()
    {
        return $this->cart->items;
    }

    /* ========================
       Cart mutations
    ========================= */

    public function addCourse(Course $course): void
    {
        // جلوگیری از خرید مجدد دوره‌ای که قبلاً خریده شده
        if (auth()->user()->courses()->where('course_id', $course->id)->exists()) {
            throw ValidationException::withMessages([
                'course' => 'You already own this course.'
            ]);
        }

        $this->cart->items()->firstOrCreate(
            ['course_id' => $course->id],
            ['price' => $course->price]
        );
    }

    public function removeCourse(Course $course): void
    {
        $this->cart->items()
            ->where('course_id', $course->id)
            ->delete();
    }

    public function clear(): void
    {
        $this->cart->items()->delete();
        $this->cart->coupon_id = null;
        $this->cart->save();
    }

    /* ========================
       Coupon
    ========================= */

    public function applyCoupon(Coupon $coupon): void
    {
        if (! $coupon->isValidForUser(auth()->user(), $this->cart)) {
            throw ValidationException::withMessages([
                'coupon' => 'Coupon is not valid.'
            ]);
        }

        $this->cart->coupon_id = $coupon->id;
        $this->cart->save();
    }

    public function removeCoupon(): void
    {
        $this->cart->coupon_id = null;
        $this->cart->save();
    }

    /* ========================
       Calculations
    ========================= */

    public function subtotal(): int
    {
        return $this->cart->items->sum('price');
    }

    public function discount(): int
    {
        if (! $this->cart->coupon) {
            return 0;
        }

        return $this->cart->coupon->calculateDiscount($this->subtotal());
    }

    public function total(): int
    {
        return max(0, $this->subtotal() - $this->discount());
    }

    /* ========================
       API-ready summary
    ========================= */

    public function summary(): array
    {
        return [
            'items' => $this->items()->map(fn ($item) => [
                'course_id' => $item->course_id,
                'title'     => $item->course->title,
                'price'     => $item->price,
            ]),
            'subtotal' => $this->subtotal(),
            'discount' => $this->discount(),
            'total'    => $this->total(),
            'coupon'   => optional($this->cart->coupon)->code,
        ];
    }
}
