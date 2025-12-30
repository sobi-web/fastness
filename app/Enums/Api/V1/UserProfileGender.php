<?php

namespace App\Enums\Api\V1;

enum UserProfileGender : string
{
    case MALE = "male";
    case FEMALE = "female";
    case OTHER = "other";

    public function persianName(): string
    {
        return match($this) {
            self::MALE => 'مرد',
            self::FEMALE => 'زن',
            self::OTHER => 'نامشخص',
        };
    }
}
