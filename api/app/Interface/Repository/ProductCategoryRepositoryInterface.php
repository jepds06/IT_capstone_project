<?php

namespace App\Interface\Repository;

interface ProductCategoryRepositoryInterface
{
    public function findMany();

    public function findOneByID(int $prodcat_Id);

    public function create(object $payload);

    public function update(object $payload, int $prodcat_Id);

}