<?php

namespace App\Filament\Resources\User\User;

use App\Filament\Resources\User\User\Pages\CreateUser;
use App\Filament\Resources\User\User\Pages\EditUser;
use App\Filament\Resources\User\User\Pages\ListUsers;
use App\Filament\Resources\User\User\Pages\ViewUser;
use App\Filament\Resources\User\User\Schemas\UserForm;
use App\Filament\Resources\User\User\Schemas\UserInfolist;
use App\Filament\Resources\User\User\Tables\UsersTable;
use App\Filament\Resources\User\User\UserResource\RelationManagers\ProfileRelationManager;
use App\Models\User\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'users';
    protected static ?string $navigationLabel = 'کاربران';
    protected static ?string $modelLabel = 'کاربر';


    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {

        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProfileRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
