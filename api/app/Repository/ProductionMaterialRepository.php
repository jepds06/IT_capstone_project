<?php

namespace App\Repository;

use App\Interface\Repository\ProductionMaterialRepositoryInterface;
use App\Models\ProductionDetail;
use App\Models\ProductionMaterial;
use App\Models\ProductMaterial;

class ProductionMaterialRepository implements ProductionMaterialRepositoryInterface
{
    public function findMany()
    {
        return ProductionMaterial::paginate(10);
    }

    public function findOneById(int $prodtnMtrlId)
    {
        return ProductionMaterial::findOrFail($prodtnMtrlId);
    }

    public function create(object $payload)
    {
        $prodtnMatrl = new ProductionMaterial();
        $prodtnDetail = ProductionDetail::find($payload->prodtnDetailID);

        if($prodtnDetail){
            $prodtnMatrl->productionDetail()->associate($prodtnDetail);
        } else {
            throw new \Exception("Invalid production detail ID provided");
        }

        $prodMatrl = ProductMaterial::find($payload->productMatsID);
        if($prodMatrl){
            $prodtnMatrl->productMaterial()->associate($prodMatrl);
        } else {
            throw new \Exception("Invalid product material ID provided");
        }

        $prodtnMatrl->qtyNeeded = $payload->qtyNeeded;
        $prodtnMatrl->status = $payload->status;

        $prodtnMatrl->save();

        return $prodtnMatrl->fresh();
    }

    public function update(object $payload, int $prodtnMtrlId)
    {
        $prodtnMatrl = ProductionMaterial::findOrFail($prodtnMtrlId);
        $prodtnDetail = ProductionDetail::find($payload->prodtnDetailID);

        if($prodtnDetail){
            $prodtnMatrl->productionDetail()->associate($prodtnDetail);
        } else {
            throw new \Exception("Invalid production detail ID provided");
        }

        $prodMatrl = ProductMaterial::find($payload->productMatsID);
        if($prodMatrl){
            $prodtnMatrl->productMaterial()->associate($prodMatrl);
        } else {
            throw new \Exception("Invalid product material ID provided");
        }

        $prodtnMatrl->qtyNeeded = $payload->qtyNeeded;
        $prodtnMatrl->status = $payload->status;

        $prodtnMatrl->save();

        return $prodtnMatrl->fresh();
    }

    public function findProdtnDetailsByProdMatsId(int $productionDetailsID)
    {
        // Fetch the product details along with its materials
        $productDetail = ProductionDetail::with('productionMaterials.productionDetails')->find($productionDetailsID);

        // Check if the product detail exists
        if (!$productDetail) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // Return the product detail and its associated materials as JSON
        return response()->json($productDetail);
    }
}