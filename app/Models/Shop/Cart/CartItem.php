<?php

namespace App\Models\Shop\Cart;

use App\Models\Shop\Course\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\Cart\CartItemFactory> */
    use HasFactory;
    protected $fillable = [
        'cart_id',
        'course_id',
        'quantity',
        'unit_price',
        'discount_amount',
        'final_price',
    ];


    protected static function booted()
    {
        static::saving(function (CartItem $item) {
            if ($item->course_id) {
                $item->quantity = 1;
            }
        });
    }
    public function cart() {
        return $this->belongsTo(Cart::class);
    }
    public function course() {
        return $this->belongsTo(Course::class);

    }



    /* ========================
    Price Logic

    ========================= */

    public function recalculate(): void
    {
        $gross = $this->unit_price * $this->quantity;

        $this->final_price = max(
            0,
            $gross - $this->discount_amount
        );

        $this->save();
    }
}
