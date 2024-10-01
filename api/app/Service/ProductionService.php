<?php

namespace App\Service;

use App\Http\Resources\ProductionResource;
use App\Interface\Repository\ProductionRepositoryInterface;
use App\Interface\Service\ProductionServiceInterface;

class ProductionService implements ProductionServiceInterface
{
    private $productionRepository;

    public function __construct(ProductionRepositoryInterface $productionRepository)
    {
        $this->productionRepository = $productionRepository;
    }

    public function findProductions()
    {
        $productions = $this->productionRepository->findMany();

        return ProductionResource::collection($productions);
    }

    public function findProductionById(int $productionId)
    {
        $production = $this->productionRepository->findOneByID($productionId);

        return new ProductionResource($production);
    }

    public function createProduction(object $payload)
    {
        $production = $this->productionRepository->create($payload);

        return new ProductionResource($production);
    }

    public function updateProduction(object $payload, int $productionId)
    {
        $production = $this->productionRepository->update($payload, $productionId);

        return new ProductionResource($production);
    }
}