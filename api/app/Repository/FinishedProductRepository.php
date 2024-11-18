<?php

namespace App\Repository;

use App\Interface\Repository\FinishedProductRepositoryInterface;
use App\Models\FinishedProduct;
use App\Models\ProductionDetail;

class FinishedProductRepository implements FinishedProductRepositoryInterface
{
    public function findMany()
    {
        return FinishedProduct::with(['productionDetail', 'productionDetail.product'])->paginate(10);
    }

    public function findOneById(int $fnshProductId)
    {
        return FinishedProduct::findOrFail($fnshProductId);
    }

    public function create(object $payload)
    {
        $fnshProduct = new FinishedProduct();

        $prodtnDetail = ProductionDetail::find($payload->prodtnDetailID);

        if($prodtnDetail){
            $fnshProduct->productionDetail()->associate($prodtnDetail);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $fnshProduct->productionDate = $payload->productionDate;
        $fnshProduct->quantity = $payload->quantity;
        $fnshProduct->unitPrice = $payload->unitPrice;
        $fnshProduct->status = $payload->status;
        $fnshProduct->remarks = $payload->remarks;

        $fnshProduct->save();

        return $fnshProduct->fresh();
    }
    
    public function update(object $payload, int $fnshProductId)
    {
        $fnshProduct = FinishedProduct::findOrFail($fnshProductId);
        $prodtnDetail = ProductionDetail::find($payload->prodtnDetailID);

        if($prodtnDetail){
            $fnshProduct->productionDetail()->associate($prodtnDetail);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $fnshProduct->productionDate = $payload->productionDate;
        $fnshProduct->quantity = $payload->quantity;
        $fnshProduct->unitPrice = $payload->unitPrice;
        $fnshProduct->status = $payload->status;
        $fnshProduct->remarks = $payload->remarks;

        $fnshProduct->save();

        return $fnshProduct->fresh();
    }
}