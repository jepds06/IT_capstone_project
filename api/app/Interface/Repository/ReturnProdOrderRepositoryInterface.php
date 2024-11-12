<?php

namespace App\Interface\Repository;

interface ReturnProdOrderRepositoryInterface
{
    public function findMany();

    public function findOneById(int $rtrnPrdOrdId);

    public function create(object $payload);

    public function update(object $payload, int $rtrnPrdOrdId);
}