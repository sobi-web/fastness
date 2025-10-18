<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpRequest;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;

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
