<?php

namespace App\Interface\Repository;

interface SalesProdOrderRepositoryInterface
{
    public function findMany();

    public function findOneById(int $slsPrdOrdId);

    public function create(object $payload);

    public function update(object $payload, int $slsPrdOrdId);
}