<?php

namespace App\Models\Shop\Cart;

use App\Models\Shop\Coupon\Coupon;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\Cart\CartFactory> */
    use HasFactory;


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

}
