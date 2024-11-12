<?php

namespace App\Interface\Service;

interface ReturnProdOrderServiceInterface
{
    public function findReturnProdOrders();

    public function findRtrnProdOrderById(int $rtrnProdOrdId);

    public function createRtrnProdOrder(object $payload);

    public function updateRtrnProdOrder(object $payload, int $rtrnProdOrdId);
}