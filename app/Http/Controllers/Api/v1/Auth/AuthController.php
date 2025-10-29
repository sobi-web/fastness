<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\InvalidOtpCodeException;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Api\V1\Auth\OtpVerifyRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\OtpService;
use App\Services\Userservice;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseApiController
{
    public function verifyOtp(OtpVerifyRequest $request, OtpService $otpService)
    {
        try {
            $flow_token = $request->flow_token;
            $code = $request->code;
            $otp = $otpService->verify($flow_token, $code);


            if ($otp === null) {

                return $this->apiResponse(201, 'عملیات با خطا مواجه شد');

            }

            $user = Userservice::findOrCreateByPhone($otp->phone);

            // صدور توکن Sanctum
            $create_token = $user->createToken( "{$otp->phone}". 'fastness_api_token');
            $token = $create_token->plainTextToken;

            $otp->setAsVerified();

            $created_user = UserResource::make($user);

            return $this->apiResponse(
                200,
                'ورود شما با موفقیت انجام شد ',
                [
                    'token' => $token,
                    'user' => $created_user,
                    'ProfileCompleted' => $user->isProfileCompleted(),
                ]
            );



        }catch (InvalidOtpCodeException $e) {
            throw ValidationException::withMessages([
               'otp' => $e->getMessage(),
            ]);

        }


    }


    public function logout(Request $request) {


        $request->user()->currentAccessToken()->delete();


        return $this->apiResponse(
            200,
            'با موفقیت از حساب کاربری خود خارج شده اید'
        );

    }
}
