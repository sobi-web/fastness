<?php

namespace App\Filament\Pages\Auth;

use App\Models\User\User;
use App\Services\OtpService;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Auth\Pages\Login;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Filament\Schemas\Schema;


class OtpLogin extends Login
{
    protected OtpService $otpService;

    public function __construct()
    {
        $this->otpService = app(OtpService::class);
    }

    protected function getLoginUsername(): string
    {
        return 'phone';
    }

    // جلوی استفاده از email را می‌گیریم و به‌صورت صریح phone/password را برمی‌گردانیم
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'phone'    => $data['phone'] ?? null,
            'password' => $data['password'] ?? null,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Wizard::make([
                    Wizard\Step::make('credentials')
                        ->label('اطلاعات ورود')
                        ->schema([
                            TextInput::make('phone')
                                ->label('شماره موبایل')
                                ->numeric()
                                ->required()
                                ->autofocus(),

                            TextInput::make('password')
                                ->label('رمز عبور')
                                ->password()
                                ->required(),

                            Checkbox::make('remember')
                                ->label('مرا به خاطر بسپار'),
                        ])
                        ->afterValidation(fn(array $state) => $this->afterLoginValidation($state)),

                    Wizard\Step::make('verification')
                        ->label('تأیید شماره تلفن')
                        ->schema([
                            TextInput::make('code')
                                ->label('کد یکبار مصرف')
                                ->numeric()
                                ->maxLength(6)
                                ->required(),

                            Hidden::make('flow_token')->required(),
                        ]),
                ])
                    ->skippable(false)
                    ->nextAction(fn(Action $action) => $action->label('ارسال کد یکبار مصرف'))
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                                    <x-filament::button type="submit" size="sm" wire:submit="login">
                                       احراز هویت و ورود
                                    </x-filament::button>
                                BLADE
                    )))
            ])
            ->statePath('data');
    }

    public function login(): void
    {
        $data = $this->form->getState();

        $phone    = $data['phone'] ?? null;
        $password = $data['password'] ?? null;
        $otpCode  = $data['code'] ?? null; // یا 'code' اگر در فرم همین اسم رو گذاشتی
        $flow     = isset($data['flow_token']) ? (string) $data['flow_token'] : null;

        // بررسی کاربر
        $user = $phone ? User::where('phone', $phone)->first() : null;

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'data.password' => 'شماره یا رمز عبور اشتباه است.',
            ]);
        }

        // بررسی OTP
        $otp = ($flow && $otpCode)
            ? $this->otpService->verify( (string) $flow, $otpCode)
            : null;

        if (! $otp) {
            throw ValidationException::withMessages([
                'data.code' => 'کد وارد شده نامعتبر یا منقضی است.',
            ]);
        }


        // لاگین کاربر
        Filament::auth()->login($user);
        session()->regenerate();

        Notification::make()
            ->success()
            ->title('ورود موفق')
            ->body('شما با موفقیت وارد شدید.')
            ->send();
    }
    public function afterLoginValidation(array $data)
    {
        $user = User::where('phone', $data['phone'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'data.password' => 'شماره یا رمز عبور اشتباه است.',
            ]);
        }

        $otp = $this->otpService->sendTo(
            $user->phone,
            request()->ip(),
            request()->userAgent()
        );

        if (! $otp) {
            Notification::make('too_many_requests')
                ->danger()
                ->title('مشکلی به وجود آمده است')
                ->body('تعداد درخواست‌ها بیش از حد مجاز است.')
                ->send();

            return;
        }

        $this->form->fill([
            'flow_token' => (string) $otp->flow_token, // رشته          ,
            'phone'      => $user->phone ,
            'password'   => $data['password'],
            'remember'   => $data['remember'] ?? false,
        ]);

        Notification::make()
            ->success()
            ->title('کد ارسال شد')
            ->body('کد یکبار مصرف به شماره شما ارسال شد.')
            ->send();
    }


}
