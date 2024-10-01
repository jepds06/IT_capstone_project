<?php

namespace App\Repository;

use App\Interface\Repository\UserAuthRepositoryInterface;
use App\Models\User;

class UserAuthRepository implements UserAuthRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}