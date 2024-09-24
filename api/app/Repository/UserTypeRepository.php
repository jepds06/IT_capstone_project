<?php

namespace App\Repository;

use App\Interface\Repository\UserTypeRepositoryInterface;
use App\Models\UserType;
use Illuminate\Http\Response;

class UserTypeRepository implements UserTypeRepositoryInterface
{
    public function findMany()
    {
        return UserType::paginate(10);
    }

    public function findOnebyId(int $userTypeId)
    {
        return UserType::findOrFail($userTypeId);
    }

    public function create(object $payload)
    {
        $userType = new UserType();
        $userType->userTypeName = $payload->userTypeName;
        $userType->save();

        return $userType->fresh();
    }

    public function update(object $payload, int $userTypeId)
    {
        $userType = UserType::findOrFail($userTypeId);
        $userType->userTypeName = $payload->userTypeName;
        $userType->save();

        return $userType->fresh();
    }
}