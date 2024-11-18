<?php

namespace App\Interface\Service;

interface SalesDeliveryServiceInterface
{
    public function findSalesDeliveries();

    public function findSlsDeliveryById(int $deliveryId);

    public function createSlsDelivery(object $payload);

    public function updateSlsDelivery(object $payload, int $deliveryId);
}