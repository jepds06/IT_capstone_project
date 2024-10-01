<?php

namespace App\Repository;

use App\Interface\Repository\SupplierMaterialRepositoryInterface;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\SupplierMaterial;

class SupplierMaterialRepository implements SupplierMaterialRepositoryInterface
{
    public function findMany()
    {
        return SupplierMaterial::paginate(10);
    }

    public function findOneById(int $suppMatrlId)
    {
        return SupplierMaterial::findOrFail($suppMatrlId);
    }

    public function create(object $payload)
    {
        $suppMatrl = new SupplierMaterial();
        $supplier = Supplier::find($payload->supplierID);
        if($supplier){
            $suppMatrl->supplier()->associate($supplier);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid user ID provided.");
        }

        $material = Material::find($payload->materialID);
        if($material){
            $suppMatrl->material()->associate($material);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid material ID provided.");
        }
        $suppMatrl->unitPrice = $payload->unitPrice;
        //Log::debug('Supplier Material Data: ' . json_encode($suppMatrl->toArray()));

        $suppMatrl->save();

        return $suppMatrl->fresh();
    }

    public function update(object $payload, int $suppMatrlId)
    {
        $suppMatrl = SupplierMaterial::findOrFail($suppMatrlId);
        $supplier = Supplier::find($payload->supplierID);
        if($supplier){
            $suppMatrl->supplier()->associate($supplier);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid user ID provided.");
        }

        $material = Material::find($payload->materialID);
        if($material){
            $suppMatrl->material()->associate($material);
        } else {
            // Handle the error: throw an exception, return an error response, or set a default value
            throw new \Exception("Invalid material ID provided.");
        }
        $suppMatrl->unitPrice = $payload->unitPrice;

        $suppMatrl->save();

        return $suppMatrl->fresh();
    }
}