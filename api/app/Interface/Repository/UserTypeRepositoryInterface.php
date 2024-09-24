<?php

namespace App\Interface\Repository;

interface UserTypeRepositoryInterface
{
    public function findMany();

    public function findOnebyId(int $userTypeId);

    public function create(object $payload);

    public function update(object $payload, int $userTypeId);
}