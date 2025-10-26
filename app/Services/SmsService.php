<?php

namespace App\Services;

use App\Exceptions\SmsGatewayException;
use Illuminate\Support\Facades\Http;

class SmsService
{

    private string $apiKey;
    private string $baseUrl;

    public function __construct(public string $to)
    {
        $this->apiKey = config('sms.api_key');
        $this->baseUrl = "https://api.kavenegar.com/v1/{$this->apiKey}/";
    }




    public function sendOTP(string $otpCode) {
        {
            $url = $this->baseUrl . 'verify/lookup.json';

            try {
                $response = Http::withoutVerifying()
                    ->asForm()
                    ->post($url, [
                        'receptor' => $this->to,
                        'template' => config('sms.templates.login'),
                        'token' => $otpCode,
                    ]);

                return $response->throw()->json();

            } catch (\Throwable $e) {
                // لاگ خطا برای دیباگ (اختیاری)
                logger()->error('SMS send failed: '.$e->getMessage());

                // پاسخ ساده و استاندارد اگر خطایی رخ داد
                return response()->json([
                    'status' => false,
                    'message' => __('otp.otp_send_failed'),
                ]);
            }
        }
   }




}
