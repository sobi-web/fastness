<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\OtpRequest;
use App\Models\Otp;
use App\Models\User;

class OtpController extends Controller
{
    public function verify(OtpRequest $request)
    {

        $record = Otp::where('otp', $request->otp)
            ->where('created_at', '>=', now()->subMinutes(2))
            ->latest()->first();

        $user = User::where('phone', $record->phone)->first();

        if (!$user) {
            $user = User::create([
                'phone' => $record->phone,

            ]);

            $user->phone_verified_at = now();
            $user->save();


        } else {
            auth()->login($user);
        }


    }

}
