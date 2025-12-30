<?php

namespace App\Filament\Resources\Shop\Order\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('cart_id')
                    ->numeric(),
                TextInput::make('coupon_id')
                    ->numeric(),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('final_price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('payment_status')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('payment_gateway')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('payment_ref'),
                DateTimePicker::make('paid_at'),
                TextInput::make('status')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
