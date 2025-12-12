<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class CustomLogin extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getPhoneFormComponent(),
                $this->getPasswordFormComponent(),
//                $this->getRememberFormComponent(),
            ]);
    }
    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label('شماره تلفن')
            ->startsWith('09')
            ->minLength(10)
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'phone'   => $data['phone'],
            'password' => $data['password'],
        ];
    }
}
