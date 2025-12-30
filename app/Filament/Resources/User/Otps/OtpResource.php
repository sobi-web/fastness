<?php

namespace App\Filament\Resources\User\Otps;

use App\Filament\Resources\User\Otps\Pages\CreateOtp;
use App\Filament\Resources\User\Otps\Pages\EditOtp;
use App\Filament\Resources\User\Otps\Pages\ListOtps;
use App\Filament\Resources\User\Otps\Pages\ViewOtp;
use App\Filament\Resources\User\Otps\Schemas\OtpForm;
use App\Filament\Resources\User\Otps\Schemas\OtpInfolist;
use App\Filament\Resources\User\Otps\Tables\OtpsTable;
use App\Models\User\Otp;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OtpResource extends Resource
{
    protected static ?string $model = Otp::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Otp';

    public static function form(Schema $schema): Schema
    {
        return OtpForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OtpInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OtpsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOtps::route('/'),
            'create' => CreateOtp::route('/create'),
            'view' => ViewOtp::route('/{record}'),
            'edit' => EditOtp::route('/{record}/edit'),
        ];
    }
}
