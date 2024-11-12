<?php

namespace App\Interface\Repository;

interface SalesDeliveryRepositoryInterface
{
    public function findMany();

    public function findOneById(int $deliveryId);

    public function create(object $payload);

    public function update(object $payload, int $deliveryId);
}