<?php

namespace App\Interface\Service;

interface CustomerPaymentServiceInterface
{
    public function findCustomerPayments();

    public function findCustomerPaymentById(int $cstrPayId);

    public function createCustomerPayment(object $payload);

    public function updateCustomerPayment(object $payload, int $cstrPayId);
}