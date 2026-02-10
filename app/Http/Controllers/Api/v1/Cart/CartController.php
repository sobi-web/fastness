<?php

namespace App\Http\Controllers\Api\v1\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Cart\CartResource;
use App\Http\Traits\Api\V1\ApiResponse;
use App\Models\Shop\Course\Course;
use App\Services\Shop\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    public function __construct(
        private CartService $cartService

    )
    {
    }

    private function user()
    {
        return auth()->user();


    }

    public function show()
    {

        $cart = $this->cartService->get($this->user());


        if (count($cart->items) === 0) {
            return $this->successResponse(null, 'Cart is empty');
        }

        return $this->successResponse($cart, 'success');
    }


    public function add(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);


        $cart = $this->cartService->addItem($this->user(), $data['course_id']);
        if (!$cart) {
            return $this->errorResponse(null, 'Cart is not added');
        }
        return $this->successResponse($cart, 'success');
    }


    public function remove(Request $request)
    {


        $data = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
        ]);


        $cart = $this->cartService->removeItem(
            $this->user(),
            (int)$data['course_id']
        );
        if (!$cart) {
            return $this->errorResponse(null, 'item is not removed');
        }
        return $this->successResponse($cart, 'item removed');
    }

    public function applyCoupon(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $cart = $this->cartService->applyDiscount(
            $request->user(),
            $data['code']
        );

        return CartResource::make($cart);
    }

    public function removeCoupon(Request $request)
    {
        $cart = $this->cartService->removeCoupon(
            $request->user()
        );

        return CartResource::make($cart);
    }
}
