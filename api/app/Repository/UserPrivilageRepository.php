<?php

namespace App\Repository;

use App\Interface\Repository\UserPrivilageRepositoryInterface;
use App\Models\UserPrivilege;

class UserPrivilageRepository implements UserPrivilageRepositoryInterface
{
    public function findMany()
    {
        return UserPrivilege::paginate(10);
    }

    public function findOnebyId(int $userPrivilageId)
    {
        return UserPrivilege::findOrFail($userPrivilageId);
    }

    public function create(object $payload)
    {
        $userPrivilage = new UserPrivilege();
        $userPrivilage->userID = $payload->userID;
        $userPrivilage->moduleID = $payload->moduleID;
        $userPrivilage->create = $payload->create;
        $userPrivilage->update = $payload->update;
        $userPrivilage->view = $payload->view;
        $userPrivilage->cancel = $payload->cancel;
        $userPrivilage->save();

        return $userPrivilage->fresh();
    }

    public function update(object $payload, int $userPrivilageId)
    {
        $userPrivilage = UserPrivilege::findOrFail($userPrivilageId);
        $userPrivilage->userID = $payload->userID;
        $userPrivilage->moduleID = $payload->moduleID;
        $userPrivilage->create = $payload->create;
        $userPrivilage->update = $payload->update;
        $userPrivilage->view = $payload->view;
        $userPrivilage->cancel = $payload->cancel;
        $userPrivilage->save();

        return $userPrivilage->fresh();
    }
}