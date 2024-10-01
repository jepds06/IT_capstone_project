<?php

namespace App\Interface\Service;

interface ProductionServiceInterface
{
    public function findProductions();

    public function findProductionById(int $productionId);

    public function createProduction(object $payload);

    public function updateProduction(object $payload, int $productionId);
}