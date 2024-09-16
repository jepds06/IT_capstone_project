<?php

namespace App\Repository;

use App\Interface\Repository\ProductMaterialsRepositoryInterface;
use App\Models\Material;
use App\Models\Product;
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
        $product = Product::find($payload->productID);
        if($product){
            $productMats->product()->associate($product);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }
        $material = Material::find($payload->materialID);
        if($material){
            $productMats->material()->associate($material);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        };
        $productMats->quantity = $payload->quantity;
    
        $productMats->save();

        return $productMats->fresh();
    }

    public function update(object $payload, int $productMatsId)
    {
        $productMats = ProductMaterial::findOrFail($productMatsId);
        $product = Product::find($payload->productID);
        if($product){
            $productMats->product()->associate($product);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        }
        $material = Material::find($payload->materialID);
        if($material){
            $productMats->material()->associate($material);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid account type ID provided.");
        };
        $productMats->quantity = $payload->quantity;

        $productMats->save();

        return $productMats->fresh();
    }

}