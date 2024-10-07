<?php

namespace App\Interface\Service;

interface ProductMaterialServiceInterface
{
    public function findProductMats();

    public function findProductMatsById(int $productMatsId);

    public function createProductMats(object $payload);

    public function updateProductMats(object $payload, int $productMatsId);

    public function findProdMatsByProductId(int $productMatsId);
}