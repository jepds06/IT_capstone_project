<?php

namespace App\Repository;

use App\Interface\Repository\ProductCategoryRepositoryInterface;
use App\Models\Product_Category;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function findMany()
    {
        return Product_Category::paginate(10);
    }

    public function findOnebyId(int $prodcat_Id)
    {
        return Product_Category::findOrFail($prodcat_Id);
    }

    public function create(object $payload)
    {
        $prodCatType = new Product_Category();
        $prodCatType->description = $payload->description;
        $prodCatType->save();

        return $prodCatType->fresh();
    }

    public function update(object $payload, int $prodcat_Id)
    {
        $prodCatType = Product_Category::findOrFail($prodcat_Id);
        $prodCatType->description = $payload->description;
        $prodCatType->save();

        return $prodCatType->fresh();
    }
}