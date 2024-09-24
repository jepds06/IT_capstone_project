<?php

namespace App\Interface\Service;

interface ProductCategoryServiceInterface
{
    public function findProductCategory();

    public function findProdCatById(int $prodcat_Id);

    public function createProductCategory(object $payload);

    public function updateProductCategory(object $payload, int $prodcat_Id);

}