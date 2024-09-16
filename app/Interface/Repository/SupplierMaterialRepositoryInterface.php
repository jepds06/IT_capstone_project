<?php

namespace App\Interface\Repository;

interface SupplierMaterialRepositoryInterface
{
    public function findMany();

    public function findOneById(int $suppMatrlId);

    public function create(object $payload);

    public function update(object $payload, int $suppMatrlId);
}