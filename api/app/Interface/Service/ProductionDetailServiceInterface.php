<?php

namespace App\Interface\Service;

interface ProductionDetailServiceInterface
{
    public function findProductionDetails();

    public function findProductionDetailById(int $prodtnDetailId);

    public function createProductionDetail(object $payload);

    public function updateProductionDetail(object $payload, int $prodtnDetailId);

    public function findProductionDetailByProductionID(int $productionID);
}