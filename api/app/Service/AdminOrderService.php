<?php

namespace App\Service;

use App\Http\Resources\AdminOrderResource;
use App\Interface\Repository\AdminOrderRepositoryInterface;
use App\Interface\Service\AdminOrderServiceInterface;

class AdminOrderService implements AdminOrderServiceInterface
{
    private $adminOrderRepository;

    public function __construct(AdminOrderRepositoryInterface $adminOrderRepository)
    {
        $this->adminOrderRepository = $adminOrderRepository;
    }

    public function findAdminOrder()
    {
        $adminOrder = $this->adminOrderRepository->findMany();

        return AdminOrderResource::collection($adminOrder);
    }

    public function findAdminOrdertById(int $AdminOrderId)
    {
        $adminOrder = $this->adminOrderRepository->findOneById($AdminOrderId);

        return new AdminOrderResource($adminOrder);
    }

    public function createAdminOrder(object $payload)
    {
        $adminOrder = $this->adminOrderRepository->create($payload);

        return new AdminOrderResource($adminOrder);
    }

    public function updateAdminOrder(object $payload, int $adminOrderId)
    {
        $adminOrder = $this->adminOrderRepository->update($payload, $adminOrderId);

        return new AdminOrderResource($adminOrder);
    }

    public function findAdminOrderByProductionID(int $productionID)
    {
        $adminOrder = $this->adminOrderRepository->findByProductionID($productionID);

        return $adminOrder;
    }
}