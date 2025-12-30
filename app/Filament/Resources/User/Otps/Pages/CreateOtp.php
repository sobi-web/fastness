<?php

namespace App\Filament\Resources\User\Otps\Pages;

use App\Filament\Resources\User\Otps\OtpResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOtp extends CreateRecord
{
    protected static string $resource = OtpResource::class;
}
