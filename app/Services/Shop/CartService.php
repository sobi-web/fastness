<?php

namespace App\Services\Shop;

use App\Models\Shop\Cart\Cart;
use App\Models\Shop\Cart\CartItem;
use App\Models\Shop\Course\Course;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use App\Services\Shop\CouponService;

class CartService
{
    public function __construct(
        private CouponService $couponService
    ) {}
    public function get(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id])
            ->load('items');
    }

    public function addItem(User $user, int $courseId): Cart
    {
        return DB::transaction(function () use ($user, $courseId) {

            $cart = $this->get($user);

            $course = Course::query()->findOrFail($courseId);

            $effectivePrice = $course->discount_price ?? $course->price;

            $item = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'course_id' => $course->id,
            ]);

            // قفل quantity برای Course
            $item->quantity = 1;
            $item->unit_price = $effectivePrice;
            $item->discount_amount = 0;
            $item->final_price = $effectivePrice;

            $item->save();

            $this->recalculate($cart);

            return $cart->fresh(['items.course']);
        });
    }
    public function updateItem(User $user, int $courseId, int $qty): Cart
    {
        return DB::transaction(function () use ($user, $courseId, $qty) {

            $cart = $this->get($user);

            $item = CartItem::where('cart_id', $cart->id)
                ->where('course_id', $courseId)
                ->firstOrFail();

            $item->quantity = 1;
            $item->final_price = $item->unit_price * $qty;
            $item->save();

            $this->recalculate($cart);

            return $cart->fresh('items');
        });
    }

    public function removeItem(User $user, int $courseId): Cart
    {
        return DB::transaction(function () use ($user, $courseId) {

            $cart = $this->get($user);

            CartItem::where('cart_id', $cart->id)
                ->where('course_id', $courseId)
                ->delete();

            $this->recalculate($cart);

            return $cart->fresh('items');
        });
    }

    public function clear(User $user): void
    {
        DB::transaction(function () use ($user) {

            $cart = $this->get($user);

            $cart->items()->delete();

            $cart->update([
                'coupon_id' => null,
                'discount_amount' => 0,
                'total_price' => 0,
            ]);
        });
    }

    public function applyDiscount(User $user, string $code): Cart
    {
        $cart = $this->get($user);

        $coupon = $this->couponService->findValid($code, $user, $cart);




        $discount = $this->couponService->calculate($coupon, $cart);


        // 3️⃣ اعمال روی cart
        $cart->coupon_id = $coupon->id;
        $cart->discount_amount = $discount;

        $this->recalculate($cart);

        return $cart->fresh('items');
    }

    public function recalculate(Cart $cart): void
    {
        $cart->load('items');

        $subtotal = $cart->items->sum('final_price');

        $cart->total_price = max(0, $subtotal - $cart->discount_amount);
        $cart->save();
    }

    public function removeCoupon(User $user ): Cart
    {
        $cart = $this->get($user);
        if (!$cart->coupon_id) {
            return $cart;
        }

        $cart->forceFill([
            'coupon_id'       => null,
            'discount_amount' => 0,
        ])->save();

        return $cart->refresh();
    }
}
