<?php

namespace App\Interface\Service;

interface SupplierMaterialServiceInterface
{
    public function findSupplierMaterials();

    public function findSupplierMaterialById(int $suppMatrlId);

    public function createSupplierMaterial(object $payload);

    public function updateSupplierMaterial(object $payload, int $suppMatrlId);
}