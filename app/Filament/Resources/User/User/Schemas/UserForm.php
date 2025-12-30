<?php

namespace App\Filament\Resources\User\User\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                DateTimePicker::make('phone_verified_at'),
                TextInput::make('password')
                    ->password(),
                TextInput::make('role')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
