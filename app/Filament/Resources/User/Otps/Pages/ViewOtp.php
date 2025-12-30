<?php

namespace App\Filament\Resources\User\Otps\Pages;

use App\Filament\Resources\User\Otps\OtpResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOtp extends ViewRecord
{
    protected static string $resource = OtpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
