<?php

namespace App\Interface\Repository;

interface ProductionMaterialRepositoryInterface
{
    public function findMany();

    public function findOneById(int $prodtnMtrlId);

    public function create(object $payload);

    public function update(object $payload, int $prodtnMtrlId);

    public function findProdtnDetailsByProdMatsId(int $prodtnMtrlId);
}