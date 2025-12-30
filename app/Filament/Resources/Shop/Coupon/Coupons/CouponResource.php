<?php

namespace App\Filament\Resources\Shop\Coupon\Coupons;

use App\Filament\Resources\Shop\Coupon\Coupons\Pages\CreateCoupon;
use App\Filament\Resources\Shop\Coupon\Coupons\Pages\EditCoupon;
use App\Filament\Resources\Shop\Coupon\Coupons\Pages\ListCoupons;
use App\Filament\Resources\Shop\Coupon\Coupons\Pages\ViewCoupon;
use App\Filament\Resources\Shop\Coupon\Coupons\Schemas\CouponForm;
use App\Filament\Resources\Shop\Coupon\Coupons\Schemas\CouponInfolist;
use App\Filament\Resources\Shop\Coupon\Coupons\Tables\CouponsTable;
use App\Models\Shop\Coupon\Coupon;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Coupon';

    public static function form(Schema $schema): Schema
    {
        return CouponForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CouponInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CouponsTable::configure($table);
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
            'index' => ListCoupons::route('/'),
            'create' => CreateCoupon::route('/create'),
            'view' => ViewCoupon::route('/{record}'),
            'edit' => EditCoupon::route('/{record}/edit'),
        ];
    }
}
