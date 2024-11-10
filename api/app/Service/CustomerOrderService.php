<?php

namespace App\Service;

use App\Http\Resources\CustomerOrderResource;
use App\Interface\Repository\CustomerOrderRepositoryInterface;
use App\Interface\Service\CustomerOrderServiceInterface;

class CustomerOrderService implements CustomerOrderServiceInterface
{
    private $cstrOrderRepository;

    public function __construct(CustomerOrderRepositoryInterface $cstrOrderRepository)
    {
        $this->cstrOrderRepository = $cstrOrderRepository;
    }

    public function findCustomerOrders()
    {
        $cstrOrders = $this->cstrOrderRepository->findMany();

        return CustomerOrderResource::collection($cstrOrders);
    }

    public function findCustomerOrderById(int $cstrOrderId)
    {
        $cstrOrder = $this->cstrOrderRepository->findOneById($cstrOrderId);

        return new CustomerOrderResource($cstrOrder);
    }

    public function createCustomerOrder(object $payload)
    {
        $cstrOrder = $this->cstrOrderRepository->create($payload);

        return new CustomerOrderResource($cstrOrder);
    }

    public function updateCustomerOrder(object $payload, int $cstrOrderId)
    {
        $cstrOrder = $this->cstrOrderRepository->update($payload, $cstrOrderId);

        return new CustomerOrderResource($cstrOrder);
    }
}