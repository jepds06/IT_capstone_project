<?php

namespace App\Repository;

use App\Interface\Repository\ProductionDetailRepositoryInterface;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductionDetail;

class ProductionDetailRepository implements ProductionDetailRepositoryInterface
{
    public function findMany()
    {
        return ProductionDetail::paginate(10);
    }

    public function findOneById(int $prodtnDetailId)
    {
        return ProductionDetail::findOrFail($prodtnDetailId);
    }

    public function create(object $payload)
    {
        $prodtnDetail = new ProductionDetail();
        $production = Production::find($payload->productionID);

        if($production){
            $prodtnDetail->production()->associate($production);
        } else {
            throw new \Exception("Invalid production ID provided.");
        }
        
        $product = Product::find($payload->productID);
        if($product){
            $prodtnDetail->product()->associate($product);
        } else {
            throw new \Exception("Invalid product ID provided.");
        }
        $prodtnDetail->quantity = $payload->quantity;
        $prodtnDetail->status = $payload->status;
        $prodtnDetail->remarks = $payload->remarks;

        $prodtnDetail->save();

        return $prodtnDetail->fresh();
    }

    public function update(object $payload, int $prodtnDetailId)
    {
        $prodtnDetail = ProductionDetail::findOrFail($prodtnDetailId);
        $production = Production::find($payload->productionID);

        if($production){
            $prodtnDetail->production()->associate($production);
        } else {
            throw new \Exception("Invalid production ID provided.");
        }
        
        $product = Product::find($payload->productID);
        if($product){
            $prodtnDetail->product()->associate($product);
        } else {
            throw new \Exception("Invalid product ID provided.");
        }
        $prodtnDetail->quantity = $payload->quantity;
        $prodtnDetail->status = $payload->status;
        $prodtnDetail->remarks = $payload->remarks;

        $prodtnDetail->save();

        return $prodtnDetail->fresh();
    }
}