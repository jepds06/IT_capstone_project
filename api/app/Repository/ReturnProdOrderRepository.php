<?php

namespace App\Repository;

use App\Interface\Repository\ReturnProdOrderRepositoryInterface;
use App\Models\ReturnProdOrder;
use App\Models\SalesProductOrder;

class ReturnProdOrderRepository implements ReturnProdOrderRepositoryInterface
{
    public function findMany()
    {
        return ReturnProdOrder::paginate(10);
    }

    public function findOneById(int $rtrnPrdOrdId)
    {
        return ReturnProdOrder::findOrFail($rtrnPrdOrdId);
    }

    public function create(object $payload)
    {
        $rtrnProdOrder = new ReturnProdOrder();

        $slsPrdOrder = SalesProductOrder::find($payload->slsPrdOrdID);
        if($slsPrdOrder){
            $rtrnProdOrder->salesProdOrder()->associate($slsPrdOrder);
        } else {
            throw new \Exception("Invalid sales product order ID provided");
        }

        $rtrnProdOrder->returnedDate = $payload->returnedDate;
        $rtrnProdOrder->qtyReturned = $payload->qtyReturned;
        $rtrnProdOrder->reason = $payload->reason;
        $rtrnProdOrder->refundAmount = $payload->refundAmount;

        $rtrnProdOrder->save();
        return $rtrnProdOrder->fresh();
    }

    public function update(object $payload, int $rtrnPrdOrdId)
    {
        $rtrnProdOrder = ReturnProdOrder::findOrFail($rtrnPrdOrdId);

        $slsPrdOrder = SalesProductOrder::find($payload->slsPrdOrdID);
        if($slsPrdOrder){
            $rtrnProdOrder->salesProdOrder()->associate($slsPrdOrder);
        } else {
            throw new \Exception("Invalid sales product order ID provided");
        }

        $rtrnProdOrder->returnedDate = $payload->returnedDate;
        $rtrnProdOrder->qtyReturned = $payload->qtyReturned;
        $rtrnProdOrder->reason = $payload->reason;
        $rtrnProdOrder->refundAmount = $payload->refundAmount;

        $rtrnProdOrder->save();
        return $rtrnProdOrder->fresh();
    }
}