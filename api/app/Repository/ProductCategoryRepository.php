<?php

namespace App\Repository;

use App\Interface\Repository\ProductCategoryRepositoryInterface;
use App\Models\ProductCategory;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function findMany()
    {
        return ProductCategory::paginate(100);
    }

    public function findOnebyId(int $prodcat_Id)
    {
        return ProductCategory::findOrFail($prodcat_Id);
    }

    public function create(object $payload)
    {
        $prodCatType = new ProductCategory();
        $prodCatType->description = $payload->description;
        $prodCatType->save();

        return $prodCatType->fresh();
    }

    public function update(object $payload, int $prodcat_Id)
    {
        $prodCatType = ProductCategory::findOrFail($prodcat_Id);
        $prodCatType->description = $payload->description;
        $prodCatType->save();

        return $prodCatType->fresh();
    }
}