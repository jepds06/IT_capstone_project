<?php

namespace App\Interface\Service;

interface UserRegServiceInterface
{
    public function findUsers();

    public function findUserById(int $userId);

    public function createUser(object $payload);

    public function updateUser(object $payload, int $userId);
}