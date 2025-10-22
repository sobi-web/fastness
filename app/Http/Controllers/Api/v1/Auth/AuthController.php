<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Api\V1\Auth\OtpVerifyRequest;
use App\Services\OtpService;
use App\Services\Userservice;

class AuthController extends BaseApiController
{
    public function verifyOtp(OtpVerifyRequest $request , OtpService $otpService)
    {
        $flow_token = $request->flow_token;
        $code =  $request->code;
        $otp = $otpService->verify($flow_token, $code);



        if ($otp === null) {

           return $this->apiResponse(201 , 'عملیات با خطا مواجه شد' );

        }

        $user = Userservice::findOrCreateByPhone($otp->phone);

        // صدور توکن Sanctum
        $token = $user->createToken('fastness_api')->plainTextToken;

        $otp->setAsVerified();

           return $this->apiResponse(
           true ,
           'ورود شما با موفقیت انجام شد ' ,
           [
               'token' => $token,
               'user' => $user,
           ]
           , '200' , '/dashboard');



    }
}
