<?php

namespace App\Interface\Service;

interface AdminOrderServiceInterface
{
    public function findAdminOrder();

    public function findAdminOrdertById(int $adminOrderId);

    public function createAdminOrder(object $payload);

    public function updateAdminOrder(object $payload, int $adminOrderId);
}