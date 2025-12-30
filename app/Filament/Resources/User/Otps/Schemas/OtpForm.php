<?php

namespace App\Filament\Resources\User\Otps\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OtpForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('send_count')
                    ->required()
                    ->numeric()
                    ->default(1),
                DateTimePicker::make('last_sent_at'),
                DateTimePicker::make('expires_at')
                    ->required(),
                DateTimePicker::make('verified_at'),
                TextInput::make('ip_address'),
                TextInput::make('user_agent'),
                TextInput::make('user_id')
                    ->numeric(),
            ]);
    }
}
