<?php

namespace App\Service;

use App\Http\Resources\SupplierMaterialResource;
use App\Interface\Repository\SupplierMaterialRepositoryInterface;
use App\Interface\Service\SupplierMaterialServiceInterface;

class SupplierMaterialService implements SupplierMaterialServiceInterface
{
    private $suppMaterialRepository;

    public function __construct(SupplierMaterialRepositoryInterface $suppMaterialRepository)
    {
        $this->suppMaterialRepository = $suppMaterialRepository;
    }

    public function findSupplierMaterials()
    {
        $supplierMaterials = $this->suppMaterialRepository->findMany();

        return SupplierMaterialResource::collection($supplierMaterials);
    }

    public function findSupplierMaterialById(int $suppMatrlId)
    {
        $supplierMaterial = $this->suppMaterialRepository->findOneById($suppMatrlId);

        return new SupplierMaterialResource($supplierMaterial);
    }

    public function createSupplierMaterial(object $payload)
    {
        $supplierMaterial = $this->suppMaterialRepository->create($payload);

        return new SupplierMaterialResource($supplierMaterial);
    }

    public function updateSupplierMaterial(object $payload, int $suppMatrlId)
    {
        $supplierMaterial = $this->suppMaterialRepository->update($payload, $suppMatrlId);

        return new SupplierMaterialResource($supplierMaterial);
    }
}