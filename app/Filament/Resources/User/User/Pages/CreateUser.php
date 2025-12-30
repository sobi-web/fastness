<?php

namespace App\Filament\Resources\User\User\Pages;

use App\Filament\Resources\User\User\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
