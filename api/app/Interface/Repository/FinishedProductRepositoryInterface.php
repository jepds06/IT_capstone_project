<?php

namespace App\Interface\Repository;

interface FinishedProductRepositoryInterface
{
    public function findMany();

    public function findOneById(int $fnshProductId);

    public function create(object $payload);

    public function update(object $payload, int $fnshProductId);
}