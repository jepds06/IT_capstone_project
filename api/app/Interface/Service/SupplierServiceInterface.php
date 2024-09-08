<?php

namespace App\Interface\Service;

interface SupplierServiceInterface
{
    public function findSuppliers();

    public function findSupplierById(int $supplierId);

    public function createSupplier(object $payload);

    public function updateSupplier(object $payload, int $supplierId);

    public function deleteSupplier(int $supplierId);
}