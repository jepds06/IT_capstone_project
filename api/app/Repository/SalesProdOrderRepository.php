<?php

namespace App\Repository;

use App\Interface\Repository\SalesProdOrderRepositoryInterface;
use App\Models\ProductOrder;
use App\Models\Sale;
use App\Models\SalesProductOrder;

class SalesProdOrderRepository implements SalesProdOrderRepositoryInterface
{
    public function findMany()
    {
        return SalesProductOrder::paginate(10);
    }

    public function findOneById(int $slsPrdOrdId)
    {
        return SalesProductOrder::findOrFail($slsPrdOrdId);
    }

    public function create(object $payload)
    {
        $slsPrdOrder = new SalesProductOrder();

        $sale = Sale::find($payload->salesID);
        if($sale){
            $slsPrdOrder->sale()->associate($sale);
        } else {
            throw new \Exception("Invalid sales ID provided.");
        }

        $prodOrder = ProductOrder::find($payload->prdOrdID);
        if($prodOrder){
            $slsPrdOrder->productOrder()->associate($prodOrder);
        } else {
            throw new \Exception("Invalid product order ID provided.");
        }

        $slsPrdOrder->save();
        return $slsPrdOrder->fresh();
    }

    public function update(object $payload, int $slsPrdOrdId)
    {
        $slsPrdOrder = SalesProductOrder::findOrFail($slsPrdOrdId);
        
        $sale = Sale::find($payload->salesID);
        if($sale){
            $slsPrdOrder->sale()->associate($sale);
        } else {
            throw new \Exception("Invalid sales ID provided.");
        }

        $prodOrder = ProductOrder::find($payload->prdOrdID);
        if($prodOrder){
            $slsPrdOrder->productOrder()->associate($prodOrder);
        } else {
            throw new \Exception("Invalid product order ID provided.");
        }

        $slsPrdOrder->save();
        return $slsPrdOrder->fresh();
    }
}