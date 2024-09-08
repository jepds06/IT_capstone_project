<?php

namespace App\Interface\Repository;

interface AdministratorRepositoryInterface
{
    public function findMany();

    public function findOneById(int $adminId);

    public function create(object $payload);

    public function update(object $payload, int $adminId);

    public function delete(int $adminId);
}