<?php

namespace App\Interface\Service;

interface AdminPaymentServiceInterface
{
    public function findAdminPayment();

    public function findAdminPaymentById(int $adminPaymentId);

    public function createAdminPayment(object $payload);

    public function updateAdminPayment(object $payload, int $adminPaymentId);
}