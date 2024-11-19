<?php

namespace App\Interface\Service;

interface SalesServiceInterface
{
    public function findSales();

    public function findSalesByUserId(int $userID);

    public function findSaleById(int $salesId);

    public function createSales(object $payload);

    public function updateSales(object $payload, int $salesId);
}