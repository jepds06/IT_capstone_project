<?php

namespace App\Service;

use App\Http\Resources\FinishedProductResource;
use App\Interface\Repository\FinishedProductRepositoryInterface;
use App\Interface\Service\FinishedProductServiceInterface;

class FinishedProductService implements FinishedProductServiceInterface
{
    private $fnshProdRepository;

    public function __construct(FinishedProductRepositoryInterface $fnshProdRepository)
    {
        $this->fnshProdRepository = $fnshProdRepository;
    }

    public function findFinishedProducts()
    {
        $fnshProducts = $this->fnshProdRepository->findMany();

        return FinishedProductResource::collection($fnshProducts);
    }

    public function findFinishedProductById(int $fnshProductId)
    {
        $fnshProduct = $this->fnshProdRepository->findOneById($fnshProductId);

        return new FinishedProductResource($fnshProduct);
    }

    public function createFinishedProduct(object $payload)
    {
        $fnshProduct = $this->fnshProdRepository->create($payload);

        return new FinishedProductResource($fnshProduct);
    }

    public function updateFinishedProduct(object $payload, int $fnshProductId)
    {
        $fnshProduct = $this->fnshProdRepository->update($payload, $fnshProductId);

        return new FinishedProductResource($fnshProduct);
    }
}