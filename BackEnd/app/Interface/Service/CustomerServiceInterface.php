<?php

namespace App\Interface\Service;

interface CustomerServiceInterface
{
    public function findCustomers();

    public function findCustomerById(int $cstrId);

    public function createCustomer(object $payload);

    public function updateCustomer(object $payload, int $cstrId);

    public function deleteCustomer(int $cstrId);
}