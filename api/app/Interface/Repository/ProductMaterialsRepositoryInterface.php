<?php

namespace App\Interface\Repository;

interface ProductMaterialsRepositoryInterface 
{
    public function findMany();

    public function findOneByID(int $productMatsId);

    public function create(object $payload);

    public function update(object $payload, int $productMatsId);

    public function findMaterialsByProductId(int $productMatsId);
}