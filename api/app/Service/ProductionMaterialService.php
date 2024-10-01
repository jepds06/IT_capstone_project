<?php

namespace App\Service;

use App\Http\Resources\ProductionMaterialResource;
use App\Interface\Repository\ProductionMaterialRepositoryInterface;
use App\Interface\Service\ProductionMaterialServiceInterface;

class ProductionMaterialService implements ProductionMaterialServiceInterface
{
    private $prodtnMaterialRepository;

    public function __construct(ProductionMaterialRepositoryInterface $prodtnMaterialRepository)
    {
        $this->prodtnMaterialRepository = $prodtnMaterialRepository;
    }

    public function findProductionMaterials()
    {
        $prodtnMats = $this->prodtnMaterialRepository->findMany();

        return ProductionMaterialResource::collection($prodtnMats);
    }

    public function findProductionMaterialById(int $prodtnMtrlId)
    {
        $prodtnMatrl = $this->prodtnMaterialRepository->findOneById($prodtnMtrlId);

        return new ProductionMaterialResource($prodtnMatrl);
    }

    public function createProductionMaterial(object $payload)
    {
        $prodtnMatrl = $this->prodtnMaterialRepository->create($payload);

        return new ProductionMaterialResource($prodtnMatrl);
    }

    public function updateProductionMaterial(object $payload, int $prodtnMtrlId)
    {
        $prodtnMatrl = $this->prodtnMaterialRepository->update($payload, $prodtnMtrlId);

        return new ProductionMaterialResource($prodtnMatrl);
    }

    public function findProdtnDetailsByProdMatsId(int $prodtnMtrlId)
    {
        $prodtnMats = $this->prodtnMaterialRepository->findProdtnDetailsByProdMatsId($prodtnMtrlId);
        
        return $prodtnMats;
    }
}