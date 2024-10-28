<?php

namespace App\Service;

use App\Http\Resources\AdminDeliveryResource;
use App\Interface\Repository\AdminDeliveryRepositoryInterface;
use App\Interface\Service\AdminDeliveryServiceInterface;

class AdminDeliveryService implements AdminDeliveryServiceInterface
{
    private $adminDlvrRepository;

    public function __construct(AdminDeliveryRepositoryInterface $adminDlvrRepository)
    {
        $this->adminDlvrRepository = $adminDlvrRepository;
    }

    public function findAdminDeliveries()
    {
        $adminDlvrs = $this->adminDlvrRepository->findMany();

        return AdminDeliveryResource::collection($adminDlvrs);
    }

    public function findAdminDlvrById(int $adminDlvrId)
    {
        $adminDlvr = $this->adminDlvrRepository->findOneById($adminDlvrId);

        return new AdminDeliveryResource($adminDlvr);
    }

    public function createAdminDlvr(object $payload)
    {
        $adminDlvr = $this->adminDlvrRepository->create($payload);

        return new AdminDeliveryResource($adminDlvr);
    }

    public function updateAdminDlvr(object $payload, int $adminDlvrId)
    {
        $adminDlvr = $this->adminDlvrRepository->update($payload, $adminDlvrId);

        return new AdminDeliveryResource($adminDlvr);
    }
}