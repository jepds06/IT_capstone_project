<?php

namespace App\Interface\Repository;

interface UserRegRespositoryInterface
{
    public function findMany();

    public function findOneById(int $userId);

    public function create(object $payload);

    public function update(object $payload, int $userId);
}