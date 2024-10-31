<?php

namespace App\Interface\Service;

interface AdminDeliveryServiceInterface
{
    public function findAdminDeliveries();

    public function findAdminDlvrById(int $adminDlvrId);

    public function createAdminDlvr(object $payload);

    public function updateAdminDlvr(object $payload, int $adminDlvrId);
}