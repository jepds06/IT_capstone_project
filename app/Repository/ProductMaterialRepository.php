<?php

namespace App\Repository;

use App\Interface\Repository\ProductMaterialsRepositoryInterface;
use App\Models\ProductionMaterial;
use App\Models\ProductMaterial;

class ProductMaterialRepository implements ProductMaterialsRepositoryInterface
{
    public function findMany ()
    {
        return ProductMaterial::paginate(10);
    }

    public function findOneById (int $productMatsId)
    {
        return ProductMaterial::findOrFail($productMatsId);
    }

    public function create(object $payload) 
    {
        $productMats = new ProductMaterial();
        $productMats->productID = $payload->productID;
        $productMats->materialID = $payload->materialID;
        $productMats->quantity = $payload->quantity;
    
        $productMats->save();

        return $productMats->fresh();
    }

    public function update(object $payload, int $productMatsId)
    {
        $productMats = ProductMaterial::findOrFail($productMatsId);
        $productMats->productID = $payload->productID;
        $productMats->materialID = $payload->materialID;
        $productMats->quantity = $payload->quantity;

        $productMats->save();

        return $productMats->fresh();
    }

}