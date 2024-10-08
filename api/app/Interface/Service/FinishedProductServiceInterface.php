<?php

namespace App\Interface\Service;

interface FinishedProductServiceInterface
{
    public function findFinishedProducts();

    public function findFinishedProductById(int $fnshProductId);

    public function createFinishedProduct(object $payload);

    public function updateFinishedProduct(object $payload, int $fnshProductId);
}