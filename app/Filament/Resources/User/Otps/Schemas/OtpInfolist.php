<?php

namespace App\Filament\Resources\User\Otps\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OtpInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('phone'),
                TextEntry::make('code'),
                TextEntry::make('type')
                    ->numeric(),
                TextEntry::make('status')
                    ->numeric(),
                TextEntry::make('send_count')
                    ->numeric(),
                TextEntry::make('last_sent_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('expires_at')
                    ->dateTime(),
                TextEntry::make('verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('ip_address')
                    ->placeholder('-'),
                TextEntry::make('user_agent')
                    ->placeholder('-'),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
