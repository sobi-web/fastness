<?php

namespace App\Services;

use App\Models\User;

class Userservice
{

    public static function findOrCreateByPhone(string $phone): User
    {
        $user = User::findByPhone($phone);

        if (! $user) {
            $user = self::create($phone);
        }

        return $user;
    }

    public static function create(string $phone): User
    {
        $user = User::create([
            'phone' => $phone,
        ]);

        $user->phone_verified_at = now();
        $user->save();

        return $user;
    }



}
