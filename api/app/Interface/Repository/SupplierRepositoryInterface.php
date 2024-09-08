<?php

namespace App\Interface\Repository;

interface SupplierRepositoryInterface
{
    public function findMany();

    public function findOneById(int $supplierId);

    public function create(object $payload);

    public function update(object $payload, int $supplierId);

    public function delete(int $supplierId);
}