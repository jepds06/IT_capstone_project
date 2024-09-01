<?php

namespace App\Interface\Repository;

interface AccountTypeRepositoryInterface
{
    public function findMany();

    public function findOnebyId(int $accTypeId);

    public function create(object $payload);

    public function update(object $payload, int $accTypeId);
}