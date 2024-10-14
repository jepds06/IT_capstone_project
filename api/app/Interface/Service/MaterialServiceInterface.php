<?php

namespace App\Interface\Service;

interface MaterialServiceInterface
{
    public function findMaterials();

    public function findMaterialsFromProduction($productionID);

    public function findMaterialById(int $materialId);

    public function createMaterial(object $payload);

    public function updateMaterial(object $payload, int $materialId);
}