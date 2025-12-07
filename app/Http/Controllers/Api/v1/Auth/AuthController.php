<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Exceptions\InvalidOtpCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\OtpVerifyRequest;
use App\Http\Resources\Api\V1\Dashboards\UserResource;
use App\Http\Traits\Api\V1\ApiResponse;
use App\Services\OtpService;
use App\Services\Userservice;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthController extends Controller
{
    use ApiResponse;

    public function verifyOtp(OtpVerifyRequest $request, OtpService $otpService)
    {
        try {
            $flow_token = $request->flow_token;
            $code = $request->code;
            $otp = $otpService->verify($flow_token, $code);


            if ($otp === null) {

                return $this->errorResponse('عملیات با خطا مواجه شد');

            }

            $user = Userservice::findOrCreateByPhone($otp->phone);

            // صدور توکن Sanctum
            $create_token = $user->createToken("{$otp->phone}" . 'fastness_api_token');
            $token = $create_token->plainTextToken;

            $otp->setAsVerified();

            $created_user = UserResource::make($user);

            return $this->successResponse(
                [
                    'token' => $token,
                    'user' => $created_user,
                    'ProfileCompleted' => $user->isProfileCompleted(),
                ], 'ورود شما با موفقیت انجام شد '
            );


        } catch (InvalidOtpCodeException $e) {

            throw new HttpResponseException(
                $this->errorResponse(
                    [
                        'error' => $e->getMessage(),
                    ],
                    'کد تایید اشتباه است.',
                    421)
            );

        } catch (Throwable $e) {
            // هر خطای غیرمنتظره دیگر
            \Log::error('Login Error: ' . $e->getMessage());

         return $this->errorResponse($e->getMessage(), 'Error', 500);
        }


    }


    public function logout(Request $request)
    {

        try {


            $request->user()->currentAccessToken()->delete();


            return $this->successResponse(
                null,
                'با موفقیت از حساب کاربری خود خارج شده اید'
            );

        } catch (Throwable $e) {

            \Log::error('Logout Error: ' . $e->getMessage());

            return $this->errorResponse($e->getMessage(), 'Error', 500);


        }

    }
}
