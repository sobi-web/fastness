<?php

namespace App\Enums\Api\V1;

enum CourseCommentStatus : int
{
    case PENDING = 1;
    case ACTIVE = 2;
    case REJECTED = 3;

    public function name()
    {
        return match($this) {
            self::PENDING => 'در انتظار بررسی',
            self::ACTIVE => 'تایید شده',
            self::REJECTED => 'رد شده'
        };
    }
}
