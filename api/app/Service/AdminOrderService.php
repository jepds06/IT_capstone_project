<?php

namespace App\Service;

use App\Http\Resources\AdminOrderResource;
use App\Http\Resources\FinishedProductResource;
use App\Interface\Repository\AdminOrderRepositoryInterface;
use App\Interface\Repository\FinishedProductRepositoryInterface;
use App\Interface\Service\AdminOrderServiceInterface;

class AdminOrderService implements AdminOrderServiceInterface
{
    private $AdminOrderRepository;

    public function __construct(AdminOrderRepositoryInterface $AdminOrderRepository)
    {
        $this->AdminOrderRepository = $AdminOrderRepository;
    }

    public function findAdminOrder()
    {
        $AdminOrder = $this->AdminOrderRepository->findMany();

        return AdminOrderResource::collection($AdminOrder);
    }

    public function findAdminOrdertById(int $AdminOrderId)
    {
        $AdminOrder = $this->AdminOrderRepository->findOneById($AdminOrderId);

        return new AdminOrderResource($AdminOrder);
    }

    public function createAdminOrder(object $payload)
    {
        $AdminOrder = $this->AdminOrderRepository->create($payload);

        return new AdminOrderResource($AdminOrder);
    }

    public function updateAdminOrder(object $payload, int $AdminOrderId)
    {
        $AdminOrder = $this->AdminOrderRepository->update($payload, $AdminOrderId);

        return new AdminOrderResource($AdminOrder);
    }
}