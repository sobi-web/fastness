<?php

namespace App\Filament\Resources\Shop\Order\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('cart_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('coupon_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('total_price')
                    ->money(),
                TextEntry::make('discount_amount')
                    ->numeric(),
                TextEntry::make('final_price')
                    ->money(),
                TextEntry::make('payment_status')
                    ->numeric(),
                TextEntry::make('payment_gateway')
                    ->numeric(),
                TextEntry::make('payment_ref')
                    ->placeholder('-'),
                TextEntry::make('paid_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
