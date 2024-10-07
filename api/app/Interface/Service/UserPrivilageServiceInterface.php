<?php

namespace App\Interface\Service;

interface UserPrivilageServiceInterface
{
    public function findUserPrivilage();

    public function findUserPrivilageById(int $userPrivilegeId);

    public function createUserPrivilage(object $payload);

    public function updateUserPrivilage(object $payload, int $userPrivilegeId);
}