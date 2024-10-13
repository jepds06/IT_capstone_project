<?php

namespace App\Repository;

use App\Interface\Repository\AdminOrderRepositoryInterface;
use App\Models\AdminOrder;
use App\Models\SupplierMaterial;
use App\Models\User;

class AdminOrderRepository implements AdminOrderRepositoryInterface
{
    public function findMany()
    {
        return AdminOrder::paginate(10);
    }

    public function findOneById(int $adminOrderId)
    {
        return AdminOrder::findOrFail($adminOrderId);
    }

    public function create(object $payload)
    {
        $adminOrder = new AdminOrder();

        $user = User::find($payload->userID);

        if($user){
            $adminOrder->productionDetail()->associate($user);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $suppMatrl = SupplierMaterial::find($payload->suppMatrlId);

        if($suppMatrl){
            $adminOrder->productionDetail()->associate($suppMatrl);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $adminOrder->userID = $payload->userID;
        $adminOrder->suppMatrlID = $payload->suppMatrlID; 
        $adminOrder->qtyOrdered = $payload->qtyOrdered; 
        $adminOrder->amount = $payload->amount;

        $adminOrder->save();

        return $adminOrder->fresh();
    }

    
    public function update(object $payload, int $adminOrderId)
    {
        $adminOrder = new AdminOrder();

        $user = User::find($payload->userID);

        if($user){
            $adminOrder->productionDetail()->associate($user);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $suppMatrl = SupplierMaterial::find($payload->suppMatrlId);

        if($suppMatrl){
            $adminOrder->productionDetail()->associate($suppMatrl);
        } else {
            throw new \Exception("Invalid production detail ID provided.");
        }

        $adminOrder->userID = $payload->userID;
        $adminOrder->suppMatrlID = $payload->suppMatrlID; 
        $adminOrder->qtyOrdered = $payload->qtyOrdered; 
        $adminOrder->amount = $payload->amount;

        $adminOrder->save();

        return $adminOrder->fresh();
    }
}