<?php

namespace App\Interface\Repository;

interface MaterialRepositoryInterface 
{
    public function findMany();

    public function findOneByID(int $materialId);

    public function create(object $payload);

    public function update(object $payload, int $materialId);

    public function findMaterialFromProductionID($productionID);
}