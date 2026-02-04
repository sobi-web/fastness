<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\InvalidOtpCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\OtpSendRequest;
use App\Http\Traits\Api\V1\ApiResponse;
use App\Services\OtpService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class OtpController extends Controller
{
    use ApiResponse;

    public function __construct(private OtpService $otpService)
    {
    }


    public function send(OtpSendRequest $request, OtpService $otpService)
    {
        try {


            $phone = $request->phone;
            $userAgent = $request->userAgent();
            $ip = $request->ip();


            if ($this->otpService->tooManyRequests($phone)) {
                return $this->errorResponse('تعداد درخواست‌های ارسال کد زیاد است. لطفا پس از چند دقیقه دوباره تلاش کنید.', 'Error', 429);

            }

            $otp = $this->otpService->sendTo($phone, $ip, $userAgent);

            $expiresAt = Carbon::parse($otp->expires_at);
            $diffInMinutes = now()->diffInSeconds($expiresAt);
            $minutes = floor($diffInMinutes / 60);
            $seconds = $diffInMinutes % 60;


            return $this->successResponse([
                'flow_token' => $otp->flow_token,
                'expires_at' => "کد  تا {$minutes} دقیقه و {$seconds} ثانیه دیگر منقضی می‌شود.",
            ], 'کد ارسال شد');

        } catch (InvalidOtpCodeException $e) {

            \Log::error('OTP Send Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return $this->errorResponse($e->getMessage(), 'Error', 500);
        }


    }


}
