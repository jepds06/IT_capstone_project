<?php

namespace App\Interface\Repository;

interface ProductionRepositoryInterface
{
    public function findMany();

    public function findOneByID(int $productionId);

    public function create(object $payload);

    public function update(object $payload, int $productionId);
}