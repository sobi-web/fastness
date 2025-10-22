<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Api\V1\Auth\OtpSendRequest;
use App\Services\OtpService;

class OtpController extends BaseApiController
{

    public function __construct(private OtpService $otpService)
    {
    }


    public function send(OtpSendRequest $request, OtpService $otpService)
    {

        $phone = $request->phone;
        $userAgent = $request->userAgent();
        $ip = $request->ip();


        if ($this->otpService->tooManyRequests($phone)) {
            return $this->apiResponse(false, 'تعداد درخواست‌های ارسال کد زیاد است. لطفا پس از چند دقیقه دوباره تلاش کنید.');

        }

        $otp = $this->otpService->sendTo($phone, $ip, $userAgent);


        return $this->apiResponse(true, 'کد ارسال شد.', [
            'flow_token' => $otp->flow_token,
            'expires_at' => $otp->expires_at,
        ] , '200' , 'auth/otp/verify');


    }


    public function verify(OtpRequest $request, OtpService $otpService)
    {



    }






}
