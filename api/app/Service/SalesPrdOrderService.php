<?php

namespace App\Service;

use App\Http\Resources\SalesProductOrderResource;
use App\Interface\Repository\SalesProdOrderRepositoryInterface;
use App\Interface\Service\SalesPrdOrdServiceInterface;

class SalesPrdOrderService implements SalesPrdOrdServiceInterface
{
    private $slsPrdOrderRepository;

    public function __construct(SalesProdOrderRepositoryInterface $slsPrdOrderRepository)
    {
        $this->slsPrdOrderRepository = $slsPrdOrderRepository;
    }

    public function findSalesPrdOrders()
    {
        $slsPrdOrders = $this->slsPrdOrderRepository->findMany();

        return SalesProductOrderResource::collection($slsPrdOrders);
    }

    public function findSalesPrdOrderById(int $slsPrdOrdId)
    {
        $slsPrdOrder = $this->slsPrdOrderRepository->findOneById($slsPrdOrdId);

        return new SalesProductOrderResource($slsPrdOrder);
    }

    public function createSalesPrdOrder(object $payload)
    {
        $slsPrdOrder = $this->slsPrdOrderRepository->create($payload);

        return new SalesProductOrderResource($slsPrdOrder);
    }

    public function updateSalesPrdOrder(object $payload, int $slsPrdOrdId)
    {
        $slsPrdOrder = $this->slsPrdOrderRepository->update($payload, $slsPrdOrdId);

        return new SalesProductOrderResource($slsPrdOrder);
    }
}