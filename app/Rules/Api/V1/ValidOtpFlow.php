<?php

namespace App\Rules\Api\V1;

use App\Models\Otp;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidOtpFlow implements ValidationRule
{
    /**
     * بررسی معتبر بودن flow_token در جدول otps
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // بررسی وجود flow token
        $otp = Otp::where('flow_token', $value)
            ->where('status', 1)
            ->first();

        if (! $otp) {
            $fail(__('otp.invalid_flow_token'));
        }
    }
}
