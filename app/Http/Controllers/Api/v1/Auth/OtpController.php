<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Api\V1\Auth\OtpSendRequest;
use App\Services\OtpService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class OtpController extends BaseApiController
{

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
                return $this->apiResponse(201, 'تعداد درخواست‌های ارسال کد زیاد است. لطفا پس از چند دقیقه دوباره تلاش کنید.');

            }

            $otp = $this->otpService->sendTo($phone, $ip, $userAgent);

            $expiresAt = Carbon::parse($otp->expires_at);
            $diffInMinutes = now()->diffInSeconds($expiresAt);
            $minutes = floor($diffInMinutes / 60);
            $seconds = $diffInMinutes % 60;


            return $this->apiResponse(200, 'کد ارسال شد.', [
                'flow_token' => $otp->flow_token,
                'expires_at' => "کد  تا {$minutes} دقیقه و {$seconds} ثانیه دیگر منقضی می‌شود.",
            ]);

        } catch (ModelNotFoundException $e) {
            // اگر مثلا کاربر یا رکورد مرتبط پیدا نشد
            \Log::warning('OTP Send - Model not found: '.$e->getMessage());
            return $this->apiResponse(404, 'کاربر یا اطلاعات مورد نظر یافت نشد.');

        } catch (Throwable $e) {
            // هر خطای غیرمنتظره دیگر
            \Log::error('OTP Send Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return $this->apiResponse(500, 'خطای داخلی سرور هنگام ارسال کد.');
        }


    }








}
