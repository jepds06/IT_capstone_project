<?php

namespace App\Interface\Repository;

interface ProductionDetailRepositoryInterface
{
    public function findMany();

    public function findOneById(int $prodtnDetailId);

    public function create(object $payload);

    public function update(object $payload, int $prodtnDetailId);

    public function findListByProductionId(int $productionID);
}