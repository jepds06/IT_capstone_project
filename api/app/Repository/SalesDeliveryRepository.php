<?php

namespace App\Repository;

use App\Interface\Repository\SalesDeliveryRepositoryInterface;
use App\Models\Sale;
use App\Models\Sales_Delivery;

class SalesDeliveryRepository implements SalesDeliveryRepositoryInterface
{
    public function findMany()
    {
        return Sales_Delivery::paginate(10);
    }

    public function findOneById(int $deliveryId)
    {
        return Sales_Delivery::findOrFail($deliveryId);
    }

    public function create(object $payload)
    {
        $slsDelivery = new Sales_Delivery();

        $sales = Sale::find($payload->salesID);
        if($sales){
            $slsDelivery->sale()->associate($sales);
        } else {
            throw new \Exception("Invalid sales ID provided.");
        }

        $slsDelivery->deliveryDate = $payload->deliveryDate;
        $slsDelivery->deliveryAddress = $payload->deliveryAddress;
        $slsDelivery->deliveryStatus = $payload->deliveryStatus;

        $slsDelivery->save();
        return $slsDelivery->fresh();
    }

    public function update(object $payload, int $deliveryId)
    {
        $slsDelivery = Sales_Delivery::findOrFail($deliveryId);

        $sales = Sale::find($payload->salesID);
        if($sales){
            $slsDelivery->sale()->associate($sales);
        } else {
            throw new \Exception("Invalid sales ID provided.");
        }

        $slsDelivery->deliveryDate = $payload->deliveryDate;
        $slsDelivery->deliveryAddress = $payload->deliveryAddress;
        $slsDelivery->deliveryStatus = $payload->deliveryStatus;

        $slsDelivery->save();
        return $slsDelivery->fresh();
    }
}