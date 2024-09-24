<?php

namespace App\Interface\Repository;

interface UserRegRepositoryInterface
{
    public function findMany();

    public function findOneById(int $userId);

    public function create(object $payload);

    public function update(object $payload, int $userId);
}