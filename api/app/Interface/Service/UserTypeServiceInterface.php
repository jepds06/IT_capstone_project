<?php

namespace App\Interface\Service;

interface UserTypeServiceInterface
{
    public function findUserTypes();

    public function findUserTypeById(int $usertTypeId);

    public function createUserType(object $payload);

    public function updateUserType(object $payload, int $userTypeId);
}