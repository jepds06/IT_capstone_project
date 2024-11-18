<?php

namespace App\Interface\Repository;

interface ProductRepositoryInterface
{
    public function findMany();

    public function findOneById(int $productId);

    public function create(object $payload);

    public function update(object $payload, int $productId);
}