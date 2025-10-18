<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Otpstatus;
use App\Enums\Otptype;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthenticatedController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {

        $user = User::where('phone', $request->phone)->first();

        $code = rand(100000, 999999);
//
        Otp::create([
            'phone' => $request->phone,
            'code' => $code,
            'type' => Otptype::LOGIN,
            'status' => Otpstatus::PENDING,

        ]);


        $url = "https://api.kavenegar.com/v1/" . config('sms.api_key') . "/verify/lookup.json";


        $reult = Http::withoutVerifying()->asForm()->post($url, [
            'receptor' => $request->phone,
            'template' => 'VerifyLogin',
            'token' => $code

        ])->json();

        return response()->json([
            'message' => 'کد با موفقیت ارسال شد',
            'status' => 'PENDING',
            'type' => 'Login',
            'redirect' => route('otp.verify'),
            'result' => $reult
        ]);


//
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
//    public function destroy(Request $request): Response
//    {
//        Auth::guard('web')->logout();
//
////        $request->session()->invalidate();
////
////        $request->session()->regenerateToken();
//
//        return response()->noContent();
//    }
}
