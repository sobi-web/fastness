<?php

namespace App\Enums\Api\V1;

enum UserRole: int
{
    case ASHRAFI = 1;
    case ESTANDARD = 2;
    case AGENT = 3;
    case DOCTOR = 4;
    case ADMIN = 10;

    public function persianName(): string
    {
        return match($this) {
            self::ASHRAFI => 'اشرافی',
            self::ESTANDARD => 'استاندارد',
            self::AGENT => 'نماینده',
            self::DOCTOR => 'پزشک',
            self::ADMIN => 'مدیر کل',
        };
    }



}
