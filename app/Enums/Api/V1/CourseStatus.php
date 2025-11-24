<?php

namespace App\Enums\Api\V1;

enum CourseStatus: int
{

    case PENDING = 1;
    case ACTIVE = 2;
    case DRAFT = 3;


    public function name()
    {
        return match ($this) {
            self::PENDING => 'در انتظار بررسی',
            self::ACTIVE => 'تایید شده',
            self::DRAFT => 'پیش نویس'
        };
    }
}
