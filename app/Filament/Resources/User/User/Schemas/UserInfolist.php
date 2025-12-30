<?php

namespace App\Filament\Resources\User\User\Schemas;

use App\Enums\Api\V1\UserRole;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('profile.name')
                    ->label('شماره موبایل'),
                TextEntry::make('phone')
                ->label('شماره موبایل'),
                TextEntry::make('phone_verified_at')
                    ->label('تاریخ احراز هویت شماره موبایل')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('role')
                    ->label('نقش')
                    ->formatStateUsing(fn (UserRole $state) => $state->persianName())
                   ->badge()
                    ->color(fn (UserRole $state) => match ($state) {
                        UserRole::ADMIN     => 'gray',
                        UserRole::ASHRAFI   => 'success',
                        UserRole::ESTANDARD => 'danger',
                        UserRole::AGENT => 'primary',
                        UserRole::DOCTOR => 'info',

                        default             => 'gray',
                    }),


                TextEntry::make('created_at')
                    ->dateTime()
                    ->label('تاریخ ثبت نام')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->label('تاریخ آخرین تغییر')
                    ->placeholder('-'),
            ]);
    }
}
