<?php

namespace App\Filament\Resources\User\User\Pages;

use App\Enums\Api\V1\UserRole;
use App\Filament\Resources\User\User\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('همه'),
            'مدیران' => Tab::make()->query(fn ($query) => $query->where('role', UserRole::ADMIN)),
            'کاربران اشرافی' => Tab::make()->query(fn ($query) => $query->where('role', UserRole::ASHRAFI)),
            'کاربران استاندارد' => Tab::make()->query(fn ($query) => $query->where('role',UserRole::ESTANDARD)),
            'نمایندگان' => Tab::make()->query(fn ($query) => $query->where('role', UserRole::AGENT)),
            'پزشکان' => Tab::make()->query(fn ($query) => $query->where('role', UserRole::DOCTOR)),


        ];
    }
}
