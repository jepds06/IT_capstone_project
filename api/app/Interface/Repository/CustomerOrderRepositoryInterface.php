<?php

namespace App\Interface\Repository;

interface CustomerOrderRepositoryInterface
{
    public function findMany();

    public function findOneById(int $cstrOrderId);

    public function create(object $payload);

    public function update(object $payload, int $cstrOrderId);
}