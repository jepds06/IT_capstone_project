<?php

namespace App\Interface\Service;

interface ProductionMaterialServiceInterface
{
    public function findProductionMaterials();

    public function findProductionMaterialById(int $prodtnMtrlId);

    public function createProductionMaterial(object $payload);

    public function updateProductionMaterial(object $payload, int $prodtnMtrlId);

    public function findProdtnDetailsByProdMatsId(int $prodtnMtrlId);
}