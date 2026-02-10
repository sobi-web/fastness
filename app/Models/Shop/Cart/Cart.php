<?php

namespace App\Models\Shop\Cart;

use App\Models\Shop\Coupon\Coupon;
use App\Models\Shop\Course\Course;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\File;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\Cart\CartFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'coupon_id',
        'total_price',
        'discount_amount',
    ];
    protected $casts = [
        'total_price' => 'integer',
        'discount_amount' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public static function current()
    {
        return self::firstOrCreate([
            'user_id' => auth()->id(),
        ]);
    }

    public static function forUser(User $user): self
    {
        return static::firstOrCreate(
            ['user_id' => $user->id],
            [
                'total_price' => 0,
                'discount_amount' => 0,
            ]
        );
    }

    /* ========================
   Core Behavior
========================= */

    public function addCourse(Course $course, int $quantity = 1): void
    {
        DB::transaction(function () use ($course, $quantity) {

            $item = $this->items()
                ->where('course_id', $course->id)
                ->lockForUpdate()->elsefirst();

            if ($item) {
                $item->quantity += $quantity;
            } else {
                $item = $this->items()->create([
                    'course_id' => $course->id,
                    'quantity' => $quantity,
                    'unit_price' => $course->price,
                    'discount_amount' => 0,
                ]);
            }

            $item->recalculate();
            $this->recalculate();
        });
    }

    public function updateQuantity(int $courseId, int $quantity): void
    {
        DB::transaction(function () use ($courseId, $quantity) {

            $item = $this->items()
                ->where('course_id', $courseId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->quantity = $quantity;
                $item->recalculate();
            }

            $this->recalculate();
        });
    }

    public function removeCourse(int $courseId): void
    {
        DB::transaction(function () use ($courseId) {

            $this->items()
                ->where('course_id', $courseId)
                ->delete();

            $this->recalculate();
        });
    }

    public function clear(): void
    {
        DB::transaction(function () {
            $this->items()->delete();
            $this->coupon_id = null;
            $this->discount_amount = 0;
            $this->total_price = 0;
            $this->save();
        });
    }

    public function recalculate(): void
    {
        $subtotal = $this->items()->sum('final_price');

        $this->total_price = max(0, $subtotal);
        $this->save();
    }


}
