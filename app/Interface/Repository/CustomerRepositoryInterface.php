<?php

namespace App\Interface\Repository;

interface CustomerRepositoryInterface
{
    public function findMany();

    public function findOneById(int $cstrId);

    public function create(object $payload);

    public function update(object $payload, int $cstrId);

    public function delete(int $cstrId);
}
