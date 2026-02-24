<?php

namespace App\Http\Resources\Api\V1\Cart;

use App\Models\Shop\Coupon\Coupon;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request ,  ): array
    {
        return [
            'id' => $this->id,

            'items' => CartItemResource::collection(
                $this->whenLoaded('items')
            ),

            'coupon' => $this->coupon_id
                ? [
                    'code' => $this->coupon?->code,
                ]
                : null,

            'prices' => [
                'subtotal' => number_format((int) $this->items->sum('final_price')),
                'discount' => number_format((int) $this->discount_amount),
                'total'    => number_format((int) $this->total_price),
            ],
        ];
    }
}
