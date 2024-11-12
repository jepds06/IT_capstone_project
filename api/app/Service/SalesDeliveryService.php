<?php

namespace App\Service;

use App\Http\Resources\SaleDeliveryResource;
use App\Interface\Repository\SalesDeliveryRepositoryInterface;
use App\Interface\Service\SalesDeliveryServiceInterface;

class SalesDeliveryService implements SalesDeliveryServiceInterface
{
    private $slsDeliveryRepository;

    public function __construct(SalesDeliveryRepositoryInterface $slsDeliveryRepository)
    {
        $this->slsDeliveryRepository = $slsDeliveryRepository;
    }

    public function findSalesDeliveries()
    {
        $slsDeliveries = $this->slsDeliveryRepository->findMany();

        return SaleDeliveryResource::collection($slsDeliveries);
    }

    public function findSlsDeliveryById(int $deliveryId)
    {
        $slsDelivery = $this->slsDeliveryRepository->findOneById($deliveryId);

        return new SaleDeliveryResource($slsDelivery);
    }

    public function createSlsDelivery(object $payload)
    {
        $slsDelivery = $this->slsDeliveryRepository->create($payload);

        return new SaleDeliveryResource($slsDelivery);
    }

    public function updateSlDelivery(object $payload, int $deliveryId)
    {
        $slsDelivery = $this->slsDeliveryRepository->update($payload, $deliveryId);

        return new SaleDeliveryResource($slsDelivery);
    }
}