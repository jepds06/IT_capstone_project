<?php

namespace App\Interface\Service;

interface PaymentMethodServiceInterface
{
    public function findPaymentMethods();

    public function findPaymentMethodById(int $payMethodId);

    public function createPaymentMethod(object $payload);

    public function updatePaymentMethod(object $payload, int $payMethodId);
}