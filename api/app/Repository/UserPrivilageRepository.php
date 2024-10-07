<?php

namespace App\Repository;

use App\Interface\Repository\UserPrivilageRepositoryInterface;
use App\Models\Module;
use App\Models\User;
use App\Models\UserPrivilege;

class UserPrivilageRepository implements UserPrivilageRepositoryInterface
{
    public function findMany()
    {
        return UserPrivilege::paginate(10);
    }

    public function findOnebyId(int $userPrivilegeId)
    {
        return UserPrivilege::findOrFail($userPrivilegeId);
    }

    public function create(object $payload)
    {
        $userPrivilege = new UserPrivilege();
        $user = User::find($payload->userID);
        if($user){
            $userPrivilege->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }
        
        $module = Module::find($payload->moduleID);
        if($module){
            $userPrivilege->module()->associate($module);
        } else {
            throw new \Exception("Invalid module ID provided.");
        }
        $userPrivilege->create = $payload->create;
        $userPrivilege->update = $payload->update;
        $userPrivilege->view = $payload->view;
        $userPrivilege->cancel = $payload->cancel;
        $userPrivilege->save();

        return $userPrivilege->fresh();
    }

    public function update(object $payload, int $userPrivilegeId)
    {
        $userPrivilege = UserPrivilege::findOrFail($userPrivilegeId);
        $user = User::find($payload->userID);
        if($user){
            $userPrivilege->user()->associate($user);
        } else {
            throw new \Exception("Invalid user ID provided.");
        }
        
        $module = Module::find($payload->moduleID);
        if($module){
            $userPrivilege->module()->associate($module);
        } else {
            throw new \Exception("Invalid module ID provided.");
        }
        $userPrivilege->create = $payload->create;
        $userPrivilege->update = $payload->update;
        $userPrivilege->view = $payload->view;
        $userPrivilege->cancel = $payload->cancel;
        $userPrivilege->save();

        return $userPrivilege->fresh();
    }
}