<?php

namespace App\Service;

use App\Http\Resources\ProductionDetailResource;
use App\Interface\Repository\ProductionDetailRepositoryInterface;
use App\Interface\Service\ProductionDetailServiceInterface;

class ProductionDetailService implements ProductionDetailServiceInterface
{
    private $prodtnDetailRepository;

    public function __construct(ProductionDetailRepositoryInterface $prodtnDetailRepository)
    {
        $this->prodtnDetailRepository = $prodtnDetailRepository;
    }

    public function findProductionDetails()
    {
        $prodtnDetails = $this->prodtnDetailRepository->findMany();

        return ProductionDetailResource::collection($prodtnDetails);
    }

    public function findProductionDetailById(int $prodtnDetailId)
    {
        $prodtnDetail = $this->prodtnDetailRepository->findOneById($prodtnDetailId);

        return new ProductionDetailResource($prodtnDetail);
    }

    public function createProductionDetail(object $payload)
    {
        $prodtnDetail = $this->prodtnDetailRepository->create($payload);

        return new ProductionDetailResource($prodtnDetail);
    }

    public function updateProductionDetail(object $payload, int $prodtnDetailId)
    {
        $prodtnDetail = $this->prodtnDetailRepository->update($payload, $prodtnDetailId);

        return new ProductionDetailResource($prodtnDetail);
    }
    public function findProductionDetailByProductionID(int $productionID)
    {
        $prodtnDetail = $this->prodtnDetailRepository->findListByProductionId($productionID);

        return $prodtnDetail;
    }
}