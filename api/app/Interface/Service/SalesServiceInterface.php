<?php

namespace App\Interface\Service;

interface SalesServiceInterface
{
    public function findSales();

    public function findSaleById(int $salesId);

    public function createSales(object $payload);

    public function updateSales(object $payload, int $salesId);
}