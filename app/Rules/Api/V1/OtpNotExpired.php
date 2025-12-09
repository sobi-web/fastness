<?php

namespace App\Rules\Api\V1;

use App\Models\User\Otp;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OtpNotExpired implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail(__('otp.flow_required'));
            return;
        }

        $otp = Otp::where('flow_token', $value)->first();

        if (! $otp) {
            $fail(__('otp.otp_not_found'));
            return;
        }

        if (Carbon::now()->greaterThan(Carbon::parse($otp->expires_at))) {
            $fail(__('otp.otp_expired'));
        }
    }
}
