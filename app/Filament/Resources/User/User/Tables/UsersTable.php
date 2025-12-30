<?php

namespace App\Filament\Resources\User\User\Tables;

use App\Enums\Api\V1\UserProfileGender;
use App\Enums\Api\V1\UserRole;
use App\Filament\Resources\User\User\UserResource\RelationManagers\ProfileRelationManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile.avatar_url')
                    ->searchable()
                    ->label('پروفایل')
                    ->defaultImageUrl(asset('storage/defult.webp'))
                    ->circular(),
                TextColumn::make('profile.full_name')
                    ->searchable()
                    ->label('نام کامل'),
                TextColumn::make('phone')
                    ->searchable()
                    ->label('شماره موبایل'),
                TextColumn::make('profile.job_title')
                    ->searchable()
                    ->label('شغل'),
                TextColumn::make('profile.birth_date')
                    ->date()
                    ->label('تاریخ تولد')
                    ->sortable(),
                TextColumn::make('profile.gender')
                    ->label('جنسیت'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone_verified_at')
                    ->since()
                    ->label('تایید موبایل')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                BadgeColumn::make('role')
                    ->label('نقش کاربر')
                    ->formatStateUsing(fn (UserRole $state) => $state->persianName())
                    ->color(fn (UserRole $state) => match ($state) {
                        UserRole::ADMIN     => 'gray',
                        UserRole::ASHRAFI   => 'success',
                        UserRole::ESTANDARD => 'danger',
                        UserRole::AGENT => 'primary',
                        UserRole::DOCTOR => 'info',

                        default             => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
