<?php

namespace App\Service;

use App\Http\Resources\PaymentMethodResource;
use App\Interface\Repository\PaymentMethodRepositoryInterface;
use App\Interface\Service\PaymentMethodServiceInterface;

class PaymentMethodService implements PaymentMethodServiceInterface
{
    private $payMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $payMethodRepository)
    {
        $this->payMethodRepository = $payMethodRepository;
    }

    public function findPaymentMethods()
    {
        $payMethods = $this->payMethodRepository->findMany();

        return PaymentMethodResource::collection($payMethods);
    }

    public function findPaymentMethodById(int $payMethodId)
    {
        $payMethod = $this->payMethodRepository->findOneById($payMethodId);

        return new PaymentMethodResource($payMethod);
    }

    public function createPaymentMethod(object $payload)
    {
        $payMethod = $this->payMethodRepository->create($payload);

        return new PaymentMethodResource($payMethod);
    }

    public function updatePaymentMethod(object $payload, int $payMethodId)
    {
        $payMethod = $this->payMethodRepository->update($payload, $payMethodId);

        return new PaymentMethodResource($payMethod);
    }
}