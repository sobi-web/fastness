<?php

namespace App\Services;

use App\Enums\Api\V1\Otpstatus;
use App\Jobs\SentOtpSms;
use App\Models\Users\Otp;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

class OtpService
{

    public function generate(string $phone, ?string $ip = null, ?string $userAgent = null, int $type = 1): ?Otp
    {

        if ($this->tooManyRequests($phone)) {
            return null;

        }


        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $otp = Otp::updateOrCreate(
            ['phone' => $phone, 'type' => $type, 'status' => Otpstatus::PENDING],
            [
                'code' => $otpCode,
                'flow_token' => Str::uuid(),
                'expires_at' => now()->addMinutes(2),
                'last_sent_at' => now(),
                'send_count' => DB::raw('send_count + 1'),
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'status' => Otpstatus::PENDING->value,
            ]
        );

        return $otp;
    }

    /**
     * بررسی Rate Limit بر اساس تعداد درخواست‌ها
     */
    public function tooManyRequests(string $phone, int $limit = 3, int $minutes = 1): bool
    {
        // اطمینان از اینکه مدل Otp همیشه مقداردهی شده و Builder معتبر است
        $query = \App\Models\Users\Otp::query();

        // آخرین رکورد معتبر برای این شماره تلفن
        $recent = $query
            ->where('phone', $phone)
            ->whereNotNull('last_sent_at')
            ->where('last_sent_at', '>=', now()->subMinutes($minutes))
            ->orderByDesc('last_sent_at')
            ->first();

        // اگر رکوردی در بازه زمانی مشخص وجود ندارد
        if (!$recent) {
            return false;
        }

        // بررسی تعداد ارسال‌های اخیر نسبت به محدودیت
        return $recent->send_count >= $limit;
    }

    /**
     * تأیید OTP بر اساس flow_token و code
     */
    public function verify(string $flowToken, string $code): ?Otp
    {
        $otp = Otp::where('flow_token', $flowToken)
            ->where('status', Otpstatus::PENDING->value)
            ->first();


        if (!$otp) {
            return null;
        }

        if ($otp->expires_at->isPast()) {
            $otp->setAsExpired();
            return null;
        }

        if ($otp->code !== $code) {
            $otp->increment('send_count');
            $otp->setAsFailed();
            return null;
        }



        return $otp;
    }

    /**
     * پاکسازی رکوردهای منقضی‌شده برای سبک نگه داشتن دیتابیس
     */
    public function cleanupExpired(): int
    {
        return Otp::where('expires_at', '<', Carbon::now())->delete();

    }

    public function sendTo(string $phone, string $ip, string $userAgent)
    {


        $otp = $this->generate($phone, $ip, $userAgent);


        $otpCode = $otp->code;


        dispatch(new SentOtpSms($phone, $otpCode));

        return $otp;


    }


}
