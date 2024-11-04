<?php

namespace App\Service;

use App\Http\Resources\AdminPaymentResource;
use App\Interface\Repository\AdminPaymentRepositoryInterface;
use App\Interface\Service\AdminPaymentServiceInterface;

class AdminPaymentService implements AdminPaymentServiceInterface
{
    private $AdminPaymentRepository;

    public function __construct(AdminPaymentRepositoryInterface $AdminPaymentRepository)
    {
        $this->AdminPaymentRepository = $AdminPaymentRepository;
    }

    public function findAdminPayments()
    {
        $adminPayments = $this->AdminPaymentRepository->findMany();

        return AdminPaymentResource::collection($adminPayments);
    }

    public function findAdminPaymentById(int $AdminOrderId)
    {
        $adminPayment = $this->AdminPaymentRepository->findOneById($AdminOrderId);

        return new AdminPaymentResource($adminPayment);
    }

    public function createAdminPayment(object $payload)
    {
        $adminPayment = $this->AdminPaymentRepository->create($payload);

        return new AdminPaymentResource($adminPayment);
    }

    public function updateAdminPayment(object $payload, int $AdminOrderId)
    {
        $adminPayment = $this->AdminPaymentRepository->update($payload, $AdminOrderId);

        return new AdminPaymentResource($adminPayment);
    }
}