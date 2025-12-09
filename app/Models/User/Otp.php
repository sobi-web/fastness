<?php

namespace App\Models\User;

use App\Enums\Api\V1\Otpstatus;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'phone', 'code', 'flow_token', 'type', 'status',
        'send_count', 'last_sent_at', 'expires_at',
        'verified_at', 'ip_address', 'user_agent', 'user_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function setAsVerified(): void
    {
        $this->status = OtpStatus::VERIFIED->value;
        $this->verified_at = now() ;
        $this->save();
    }

    public function setAsExpired(): void
    {
        $this->status = OtpStatus::EXPIRED->value;
        $this->save();
    }

    public function setAsFailed(): void
    {
        $this->status = OtpStatus::FAILED->value;
        $this->save();
    }


}
