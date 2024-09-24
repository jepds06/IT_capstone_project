<?php

namespace App\Interface\Repository;

interface UserPrivilageRepositoryInterface
{
    public function findMany();

    public function findOnebyId(int $privilageId);

    public function create(object $payload);

    public function update(object $payload, int $privilageId);
}