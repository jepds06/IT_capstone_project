<?php

namespace App\Service;

use App\Http\Resources\ReturnProdOrderResource;
use App\Interface\Repository\ReturnProdOrderRepositoryInterface;
use App\Interface\Service\ReturnProdOrderServiceInterface;

class ReturnProdOrderService implements ReturnProdOrderServiceInterface
{
    private $rtrnProdOrderRepository;

    public function __construct(ReturnProdOrderRepositoryInterface $rtrnProdOrderRepository)
    {
        $this->rtrnProdOrderRepository = $rtrnProdOrderRepository;
    }

    public function findReturnProdOrders()
    {
        $rtrnProdOrders = $this->rtrnProdOrderRepository->findMany();

        return ReturnProdOrderResource::collection($rtrnProdOrders);
    }

    public function findRtrnProdOrderById(int $rtrnProdOrdId)
    {
        $rtrnProdOrder = $this->rtrnProdOrderRepository->findOneById($rtrnProdOrdId);

        return new ReturnProdOrderResource($rtrnProdOrder);
    }

    public function createRtrnProdOrder(object $payload)
    {
        $rtrnProdOrder = $this->rtrnProdOrderRepository->create($payload);

        return new ReturnProdOrderResource($rtrnProdOrder);
    }

    public function updateRtrnProdOrder(object $payload, int $rtrnProdOrdId)
    {
        $rtrnProdOrder = $this->rtrnProdOrderRepository->update($payload, $rtrnProdOrdId);

        return new ReturnProdOrderResource($rtrnProdOrder);
    }
}