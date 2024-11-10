<?php

namespace App\Interface\Service;

interface CustomerOrderServiceInterface
{
    public function findCustomerOrders();

    public function findCustomerOrderById(int $cstrOrderId);

    public function createCustomerOrder(object $payload);

    public function updateCustomerOrder(object $payload, int $cstrOrderId);
}