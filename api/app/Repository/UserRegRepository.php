<?php

namespace App\Repository;

use App\Interface\Repository\UserRegRepositoryInterface;
use App\Models\User;
use App\Models\UserType;

class UserRegRepository implements UserRegRepositoryInterface
{
    public function findMany()
    {
        return User::paginate(10);
    }

    public function findOneById(int $userId)
    {
        return User::findOrFail($userId);
    }

    public function create(object $payload)
    {
        $user = new User();
        $user->firstName = $payload->firstName;
        $user->lastName = $payload->lastName;
        $user->userName = $payload->userName;
        $user->email = $payload->email;
        $user->password = $payload->password;
        $userType = UserType::find($payload->userTypeID);

        if($userType){
            $user->userType()->associate($userType);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid user type ID provided.");
        }

        $user->save();

        return $user->fresh();
    }

    public function update(object $payload, int $userId)
    {
        $user = User::findOrFail($userId);
        $user->firstName = $payload->firstName;
        $user->lastName = $payload->lastName;
        $user->userName = $payload->userName;
        $user->email = $payload->email;
        $user->password = $payload->password;
        $userType = UserType::find($payload->userTypeID);

        if($userType){
            $user->userType()->associate($userType);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }

        $user->save();

        return $user->fresh();
    }
}