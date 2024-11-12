<?php

namespace App\Interface\Repository;

interface AdminOrderRepositoryInterface
{
    public function findMany();

    public function findOneById(int $adminOrderId);

    public function create(object $payload);

    public function update(object $payload, int $adminOrderId);

    public function findByProductionID(int $productionId);
}