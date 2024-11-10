<?php

namespace App\Service;

use App\Http\Resources\CustomerPaymentResource;
use App\Interface\Repository\CustomerPaymentRepositoryInterface;
use App\Interface\Service\CustomerPaymentServiceInterface;

class CustomerPaymentService implements CustomerPaymentServiceInterface
{
    private $cstrPayRepository;

    public function __construct(CustomerPaymentRepositoryInterface $cstrPayRepository)
    {
        $this->cstrPayRepository = $cstrPayRepository;
    }

    public function findCustomerPayments()
    {
        $cstrPayments = $this->cstrPayRepository->findMany();

        return CustomerPaymentResource::collection($cstrPayments);
    }

    public function findCustomerPaymentById(int $cstrPayId)
    {
        $cstrPayment = $this->cstrPayRepository->findOneById($cstrPayId);

        return new CustomerPaymentResource($cstrPayment);
    }

    public function createCustomerPayment(object $payload)
    {
        $cstrPayment = $this->cstrPayRepository->create($payload);

        return new CustomerPaymentResource($cstrPayment);
    }

    public function updateCustomerPayment(object $payload, int $cstrPayId)
    {
        $cstrPayment = $this->cstrPayRepository->update($payload, $cstrPayId);

        return new CustomerPaymentResource($cstrPayment);
    }
}