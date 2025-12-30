<?php

namespace App\Filament\Resources\Shop\Coupon\Coupons\Pages;

use App\Filament\Resources\Shop\Coupon\Coupons\CouponResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCoupon extends ViewRecord
{
    protected static string $resource = CouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
