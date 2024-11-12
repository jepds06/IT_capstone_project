<?php

namespace App\Interface\Repository;

interface SalesRepositoryInterface
{
    public function findMany();

    public function findOneById(int $salesId);

    public function create(object $payload);

    public function update(object $payload, int $salesId);
}