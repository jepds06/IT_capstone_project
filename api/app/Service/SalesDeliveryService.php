<?php

namespace App\Service;

use App\Http\Resources\SalesDeliveryResource;
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

        return SalesDeliveryResource::collection($slsDeliveries);
    }

    public function findSlsDeliveryById(int $deliveryId)
    {
        $slsDelivery = $this->slsDeliveryRepository->findOneById($deliveryId);

        return new SalesDeliveryResource($slsDelivery);
    }

    public function createSlsDelivery(object $payload)
    {
        $slsDelivery = $this->slsDeliveryRepository->create($payload);

        return new SalesDeliveryResource($slsDelivery);
    }

    public function updateSlsDelivery(object $payload, int $deliveryId)
    {
        $slsDelivery = $this->slsDeliveryRepository->update($payload, $deliveryId);

        return new SalesDeliveryResource($slsDelivery);
    }
}