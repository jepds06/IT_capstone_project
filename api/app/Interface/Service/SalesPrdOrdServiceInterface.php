<?php

namespace App\Interface\Service;

interface SalesPrdOrdServiceInterface
{
    public function findSalesPrdOrders();

    public function findSalesPrdOrderById(int $slsPrdOrdId);

    public function createSalesPrdOrder(object $payload);

    public function updateSalesPrdOrder(object $payload, int $slsPrdOrdId);
}