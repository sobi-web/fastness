<?php

namespace App\Filament\Resources\User\Otps\Pages;

use App\Filament\Resources\User\Otps\OtpResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOtps extends ListRecords
{
    protected static string $resource = OtpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
